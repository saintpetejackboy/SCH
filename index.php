<?php
include_once('dbconn.php');

// Capture the JSON POST payload
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if ($data === null) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON"]);
    exit;
}

// Check if the project already exists
$checkStmt = $pdo->prepare("SELECT id FROM projects WHERE subhub_id = :subhub_id");
$checkStmt->bindParam(':subhub_id', $data['data']['subhub_id']);
$checkStmt->execute();
$projectId = $checkStmt->fetchColumn();

// If the project exists, update it, otherwise insert a new project
if ($projectId) {
    $stmt = $pdo->prepare("
        UPDATE projects SET
            event = :event, external_id = :external_id, job_type = :job_type, street = :street, city = :city, state = :state, 
            county = :county, postal_code = :postal_code, country = :country, territory = :territory, latitude = :latitude, 
            longitude = :longitude, downpayment = :downpayment, discounts_total = :discounts_total, base_system_cost = :base_system_cost, 
            battery_total = :battery_total, adders_total = :adders_total, dealer_fee = :dealer_fee, annual_usage = :annual_usage, 
            contract_amount = :contract_amount, utility_company = :utility_company, utility_bill = :utility_bill, module_name = :module_name, 
            module_manufacturer = :module_manufacturer, module_watts = :module_watts, module_description = :module_description, 
            module_total_panels = :module_total_panels, inverter_name = :inverter_name, inverter_manufacturer = :inverter_manufacturer, 
            inverter_quantity = :inverter_quantity, battery_name = :battery_name, battery_manufacturer = :battery_manufacturer, 
            battery_price = :battery_price, battery_size_kwh = :battery_size_kwh, battery_quantity = :battery_quantity, 
            annual_production = :annual_production, finance_type = :finance_type, contract_type = :contract_type, finance_partner = :finance_partner, 
            finance_term_year = :finance_term_year, finance_rate = :finance_rate, finance_escalator_rate = :finance_escalator_rate, 
            finance_ppw = :finance_ppw, finance_monthly_payment = :finance_monthly_payment, first_name = :first_name, last_name = :last_name, 
            name = :name, email = :email, phone = :phone, owner_email = :owner_email, proposal_url = :proposal_url, 
            contract_signed_url = :contract_signed_url, system_size_kw = :system_size_kw, system_size_w = :system_size_w, 
            sales_representative_name = :sales_representative_name, sales_representative_email = :sales_representative_email
        WHERE subhub_id = :subhub_id
    ");
} else {
    $stmt = $pdo->prepare("
        INSERT INTO projects (
            event, external_id, job_type, street, city, state, county, postal_code, country, territory, latitude, longitude, 
            downpayment, discounts_total, base_system_cost, battery_total, adders_total, dealer_fee, annual_usage, subhub_id, 
            contract_amount, utility_company, utility_bill, module_name, module_manufacturer, module_watts, module_description, 
            module_total_panels, inverter_name, inverter_manufacturer, inverter_quantity, battery_name, battery_manufacturer, 
            battery_price, battery_size_kwh, battery_quantity, annual_production, finance_type, contract_type, finance_partner, 
            finance_term_year, finance_rate, finance_escalator_rate, finance_ppw, finance_monthly_payment, first_name, last_name, 
            name, email, phone, owner_email, proposal_url, contract_signed_url, system_size_kw, system_size_w, sales_representative_name, 
            sales_representative_email
        ) VALUES (
            :event, :external_id, :job_type, :street, :city, :state, :county, :postal_code, :country, :territory, :latitude, :longitude, 
            :downpayment, :discounts_total, :base_system_cost, :battery_total, :adders_total, :dealer_fee, :annual_usage, :subhub_id, 
            :contract_amount, :utility_company, :utility_bill, :module_name, :module_manufacturer, :module_watts, :module_description, 
            :module_total_panels, :inverter_name, :inverter_manufacturer, :inverter_quantity, :battery_name, :battery_manufacturer, 
            :battery_price, :battery_size_kwh, :battery_quantity, :annual_production, :finance_type, :contract_type, :finance_partner, 
            :finance_term_year, :finance_rate, :finance_escalator_rate, :finance_ppw, :finance_monthly_payment, :first_name, :last_name, 
            :name, :email, :phone, owner_email, :proposal_url, :contract_signed_url, :system_size_kw, :system_size_w, :sales_representative_name, 
            :sales_representative_email
        )
    ");
}

// Bind parameters
$params = [
    ':event' => $data['event'] ?? null,
    ':external_id' => $data['data']['external_id'] ?? null,
    ':job_type' => $data['data']['job_type'] ?? null,
    ':street' => $data['data']['street'] ?? null,
    ':city' => $data['data']['city'] ?? null,
    ':state' => $data['data']['state'] ?? null,
    ':county' => $data['data']['county'] ?? null,
    ':postal_code' => $data['data']['postal_code'] ?? null,
    ':country' => $data['data']['country'] ?? null,
    ':territory' => $data['data']['territory'] ?? null,
    ':latitude' => $data['data']['latitude'] ?? null,
    ':longitude' => $data['data']['longitude'] ?? null,
    ':downpayment' => $data['data']['downpayment'] ?? null,
    ':discounts_total' => $data['data']['discounts_total'] ?? null,
    ':base_system_cost' => $data['data']['base_system_cost'] ?? null,
    ':battery_total' => $data['data']['battery_total'] ?? null,
    ':adders_total' => $data['data']['adders_total'] ?? null,
    ':dealer_fee' => $data['data']['dealer_fee'] ?? null,
    ':annual_usage' => $data['data']['annual_usage'] ?? null,
    ':subhub_id' => $data['data']['subhub_id'] ?? null,
    ':contract_amount' => $data['data']['contract_amount'] ?? null,
    ':utility_company' => $data['data']['utility_company'] ?? null,
    ':utility_bill' => $data['data']['utility_bill'] ?? null,
    ':module_name' => $data['data']['module_name'] ?? null,
    ':module_manufacturer' => $data['data']['module_manufacturer'] ?? null,
    ':module_watts' => $data['data']['module_watts'] ?? null,
    ':module_description' => $data['data']['module_description'] ?? null,
    ':module_total_panels' => $data['data']['module_total_panels'] ?? null,
    ':inverter_name' => $data['data']['inverter_name'] ?? null,
    ':inverter_manufacturer' => $data['data']['inverter_manufacturer'] ?? null,
    ':inverter_quantity' => $data['data']['inverter_quantity'] ?? null,
    ':battery_name' => $data['data']['battery_name'] ?? null,
    ':battery_manufacturer' => $data['data']['battery_manufacturer'] ?? null,
    ':battery_price' => $data['data']['battery_price'] ?? null,
    ':battery_size_kwh' => $data['data']['battery_size_kwh'] ?? null,
    ':battery_quantity' => $data['data']['battery_quantity'] ?? null,
    ':annual_production' => $data['data']['annual_production'] ?? null,
    ':finance_type' => $data['data']['finance_type'] ?? null,
    ':contract_type' => $data['data']['contract_type'] ?? null,
    ':finance_partner' => $data['data']['finance_partner'] ?? null,
    ':finance_term_year' => $data['data']['finance_term_year'] ?? null,
    ':finance_rate' => $data['data']['finance_rate'] ?? null,
    ':finance_escalator_rate' => $data['data']['finance_escalator_rate'] ?? null,
    ':finance_ppw' => $data['data']['finance_ppw'] ?? null,
    ':finance_monthly_payment' => $data['data']['finance_monthly_payment'] ?? null,
    ':first_name' => $data['data']['first_name'] ?? null,
    ':last_name' => $data['data']['last_name'] ?? null,
    ':name' => $data['data']['name'] ?? null,
    ':email' => $data['data']['email'] ?? null,
    ':phone' => $data['data']['phone'] ?? null,
    ':owner_email' => $data['data']['owner_email'] ?? null,
    ':proposal_url' => $data['data']['proposal_url'] ?? null,
    ':contract_signed_url' => $data['data']['contract_signed_url'] ?? null,
    ':system_size_kw' => $data['data']['system_size_kw'] ?? null,
    ':system_size_w' => $data['data']['system_size_w'] ?? null,
    ':sales_representative_name' => $data['data']['sales_representative_name'] ?? null,
    ':sales_representative_email' => $data['data']['sales_representative_email'] ?? null
];

$stmt->execute($params);

if (!$projectId) {
    $projectId = $pdo->lastInsertId();
}
// Function to check if project_id exists
function projectIdExists($pdo, $projectId) {
    $query = "SELECT COUNT(*) FROM project_stages WHERE project_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$projectId]);
    return $stmt->fetchColumn() > 0;
}

// Prepare the base queries for insert and update
$baseUpdateQuery = "UPDATE project_stages SET ";
$baseInsertQuery = "INSERT INTO project_stages (";
$insertValuesPart = ") VALUES (";
$fields = [];
$values = [];
$insertColumns = [];
$insertPlaceholders = [];

// Create an associative array to map field keys to column names
$fieldKeyToColumn = [
    'site_survey_attachment' => 'site_survey_attachment',
    'site_survey_complete' => 'site_survey_complete',
    'site_survey_notes' => 'site_survey_notes',
    'site_survey_returned' => 'site_survey_returned',
    'site_survey_schedule' => 'site_survey_schedule',
    'design_attachment' => 'design_attachment',
    'design_complete' => 'design_complete',
    'design_start' => 'design_start',
    'meter_spot_request' => 'meter_spot_request',
    'ntp_complete' => 'ntp_complete',
    'plancheck_completed' => 'plancheck_completed',
    'true_up_completed' => 'true_up_completed',
    'permit_receive' => 'permit_receive',
    'permit_request' => 'permit_request',
    'permitting_attachment' => 'permitting_attachment',
    'permitting_notes' => 'permitting_notes',
    'final_inspection_passed' => 'final_inspection_passed',
    'install_attachment' => 'install_attachment',
    'install_completed' => 'install_completed',
    'install_notes' => 'install_notes',
    'install_scheduled_date' => 'install_scheduled_date',
    'install_start_date' => 'install_start_date',
    'mpu_complete' => 'mpu_complete',
    'mpu_schedule' => 'mpu_schedule',
    'photos_received' => 'photos_received',
    'inspection_completed' => 'inspection_completed',
    'inspection_scheduled_date' => 'inspection_scheduled_date',
    'inspection_start_date' => 'inspection_start_date',
    'monitoring_completed' => 'monitoring_completed',
    'pto_attachment' => 'pto_attachment',
    'pto_notes' => 'pto_notes',
    'pto_receive' => 'pto_receive',
    'pto_request' => 'pto_request',
    'escalations' => 'escalations',
    'escalations_reason_1' => 'escalations_reason_1',
    'escalations_reason_2' => 'escalations_reason_2',
    'escalations_reason_3' => 'escalations_reason_3',
    'agent_job_status' => 'agent_job_status',
    'cancel_date' => 'cancel_date',
    'cancellation_notes' => 'cancellation_notes',
    'cancellation_reason' => 'cancellation_reason',
    'cancellation_sub_reason' => 'cancellation_sub_reason',
    'date_requested' => 'date_requested',
    'live_transfer' => 'live_transfer',
    'pending_cancel_date' => 'pending_cancel_date',
    'pending_resolution_date' => 'pending_resolution_date',
    're_save' => 're_save',
    're_save_date' => 're_save_date',
    'retention_assigned_to' => 'retention_assigned_to',
    'retention_base_reason' => 'retention_base_reason',
    'retention_set_date' => 'retention_set_date',
    'retention_specific_reason' => 'retention_specific_reason',
    'save_type' => 'save_type',
    'saved' => 'saved',
    'saved_date' => 'saved_date',
    'setter_assigned_to' => 'setter_assigned_to',
    'setter_job_status' => 'setter_job_status',
    'ntp_invoice_sent_cash' => 'ntp_invoice_sent_cash',
    'ntp_payment_received_cash' => 'ntp_payment_received_cash',
    'funding_requested_finance_' => 'funding_requested_finance_',
    'funding_approved_finance_' => 'funding_approved_finance_',
    'customer_planset_approval_sent' => 'customer_planset_approval_sent',
    'customer_planset_approved' => 'customer_planset_approved'
];

// Keep track of added columns
$addedColumns = [];

// Build the dynamic query based on the stage data
foreach ($data['data']['stages'] as $index => $stage) {
    $fieldKey = $stage['field_key'];
    if (isset($fieldKeyToColumn[$fieldKey])) {
        $columnName = $fieldKeyToColumn[$fieldKey];
        if (!in_array($columnName, $addedColumns)) {
            $fields[] = "$columnName = ?";
            $values[] = $stage['value'] ?? null;
            $insertColumns[] = $columnName;
            $insertPlaceholders[] = "?";
            $addedColumns[] = $columnName; // Add to the list of added columns
        }
    }
}

// Convert fields array to strings
$fieldsString = implode(', ', $fields);
$insertColumnsString = implode(', ', $insertColumns);
$insertPlaceholdersString = implode(', ', $insertPlaceholders);

if (!empty($fieldsString)) {
    if (projectIdExists($pdo, $projectId)) {
        // Update existing record
        $finalQuery = $baseUpdateQuery . $fieldsString . " WHERE project_id = ?";
        $values[] = $projectId;
    } else {
        // Insert new record
        $finalQuery = $baseInsertQuery . $insertColumnsString . ", project_id" . $insertValuesPart . $insertPlaceholdersString . ", ?)";
        $values[] = $projectId;
    }
    error_log(serialize($values));
    // Prepare and execute the statement
    error_log($finalQuery);
    $stagesStmt = $pdo->prepare($finalQuery);
    if (!$stagesStmt->execute($values)) {
        error_log("Error executing stages query: " . print_r($stagesStmt->errorInfo(), true));
    }
}

// Function to check if url exists
function urlExists($pdo, $url) {
    $query = "SELECT COUNT(*) FROM project_documents WHERE url = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$url]);
    return $stmt->fetchColumn() > 0;
}

// Prepare the base insert query with an update clause
$documentsStmtInsert = $pdo->prepare("
    INSERT INTO project_documents (project_id, url, label)
    VALUES (:project_id, :url, :label)
    ON DUPLICATE KEY UPDATE url = VALUES(url), label = VALUES(label)
");

// Loop through the documents and insert or update based on the existence of the url
foreach ($data['data']['documents'] as $document) {
    if (!urlExists($pdo, $document['url'])) {
        $documentsStmtInsert->execute([
            ':project_id' => $projectId,
            ':url' => $document['url'],
            ':label' => $document['label']
        ]);
    } else {
        // If the url exists, update only if needed
        $documentsStmtUpdate = $pdo->prepare("
            UPDATE project_documents SET 
                label = :label
            WHERE project_id = :project_id AND url = :url
        ");
        $documentsStmtUpdate->execute([
            ':project_id' => $projectId,
            ':url' => $document['url'],
            ':label' => $document['label']
        ]);
    }
}


echo json_encode(["status" => "success", "message" => "Data processed successfully"]);

