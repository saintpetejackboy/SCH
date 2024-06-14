<?php
// This file is a mess further down as I wait for partners to clarify some fields.

include_once('../dbconn.php');

// Fetch the most recent project
$query = "SELECT * FROM projects ORDER BY id DESC LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->execute();
$project = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch the most recent project document
$query = "SELECT * FROM project_documents WHERE project_id = :project_id ORDER BY id DESC LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':project_id', $project['id'], PDO::PARAM_INT);
$stmt->execute();
$project_document = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch the most recent project stage
$query = "SELECT * FROM project_stages WHERE project_id = :project_id ORDER BY id DESC LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':project_id', $project['id'], PDO::PARAM_INT);
$stmt->execute();
$project_stage = $stmt->fetch(PDO::FETCH_ASSOC);

// Mapping fields
$customerFirst = $project['first_name'];
$customerLast = $project['last_name'];
$location = $project['street'];
$consultant = $project['sales_representative_name'];
$recType = 'East Customers'; // Assuming this is a fixed value
$setter = $project_stage['setter_assigned_to'];
$zip = $project['postal_code'];
$city = $project['city'];
$state = $project['state'];
$phone = $project['phone'];
$email = $project['email'];
$salesRepEmail = $project['sales_representative_email'];
$address = $project['street'];
$salesRep = $project['finance_type']; // Not found in project data
$utilityAccount = $project['utility_company']; // Not found in project data
$paymentType = $project['contract_type']; // Not found in project data

if($project['system_size_kw'] <= 10.01){
$tier2 = 'No'; // Assuming this is a fixed value
} else { $tier2 = 'Yes'; }

$utility = $project['utility_company'];
$systemSize = $project['system_size_kw'];
$loanAmount = $project['contract_amount'];
$loanTerm = $project['finance_term_year'];
$panelString = $project['module_name'] . ' ' . $project['module_manufacturer'] . ' ' . $project['module_watts'] . 'W';
$inverterString = $project['inverter_name'];
$batteryCount = $project['battery_quantity'];
$batteryType = $project['battery_name'];
$leadProvider = 'Spartan'; // Not found in project data
$dealDate = date('Y-m-d H:i:s', strtotime("now")); // Not found in project data
$companyAppointment = 'No'; // Not found in project data
/*
$HOA = 'Unknown'; // Not found in project data
$HOAInfo = 'Unknown'; // Not found in project data
$grossDeal = 'Unknown'; // Not found in project data
$rebateGross = 'Unknown'; // Not found in project data
$sunnovaYN = 'Unknown'; // Not found in project data
$ballastedRacking = 'Unknown'; // Not found in project data
$groundMount = 'Unknown'; // Not found in project data
$MPU = 'Unknown'; // Not found in project data
$roofIncluded = 'Unknown'; // Not found in project data
$roofingCompany = 'Unknown'; // Not found in project data
$HVAC = 'Unknown'; // Not found in project data
$generator = 'Unknown'; // Not found in project data
$referral = 'Unknown'; // Not found in project data
$referralInfo = 'Unknown'; // Not found in project data
$roofType = 'Unknown'; // Not found in project data
$numStories = 'Unknown'; // Not found in project data
$insulationType = 'Unknown'; // Not found in project data
$mainbreakerRating = 'Unknown'; // Not found in project data
$breakerLocation = 'Unknown'; // Not found in project data
$checklistNotes = 'Unknown'; // Not found in project data
*/

// Prepare the CURL request
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://app.jobnimbus.com/api1/contacts',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode(array(
        "first_name" => $customerFirst,
        "last_name" => $customerLast,
        "Location" => $location,
        "sales_rep_name" => $consultant,
        "record_type_name" => $recType,
        "Appt Setter" => $setter,
        "status_name" => "Job Sold",
        "zip" => $zip,
        "city" => $city,
        "state_text" => $state,
        "home_phone" => $phone,
        "email" => $email,
        "Sales Rep Email" => $salesRepEmail,
        "address_line1" => $address,
        "sales_rep_name" => $salesRep,
        "Payment Method" => $paymentType,
        "Utility Account #" => $utilityAccount,
        "Payment Type" => $paymentType,
        "Tier 2 Sale" => $tier2,
        "Tier 2 Insurance Received" => "No",
        "Power Company" => $utility,
        "System Size (kW)" => $systemSize,
        "Deal Amount (Gross)" => $loanAmount,
        "Loan Term" => $loanTerm,
        "Panel Make, Model, Watt, Amt" => $panelString . ' [' . $project['module_total_panels'] . ']',
        "Inverter Type/Size" => $inverterString,
        "Battery Quantity" => $batteryCount,
        "Battery Type" => $batteryType,
        "Lead Provider" => $leadProvider,
        "Deal Date" => $dealDate,
        "Company Appointment" => $companyAppointment,
        "Installer (In House / Partner)" => "In House",
        "HOA Approval Received" => "No",
        "Lender NTP Received?" => "No",
        "Spanish Speaking" => "No"
    )),
    CURLOPT_HTTPHEADER => array(
        "Authorization: bearer $jnapi",
        'Content-Type: application/json'
    )
));

$response = curl_exec($curl);

if ($response === false) {
    // Handle cURL error
    echo "cURL Error: " . curl_error($curl);
} else {
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ($httpCode === 200) {
        // Request was successful, display success message
        echo "Success: Contact added to Job Nimbus.";
    } else {
        // Handle the error with more verbose output
        echo "Error: Failed to add contact to Job Nimbus.\n";
        echo "HTTP Code: " . $httpCode . "\n";
        echo "cURL Info: " . print_r(curl_getinfo($curl), true) . "\n";
        echo "Response: " . $response . "\n";
    }
}

curl_close($curl);

/* Old cURL request for reference when fields are resolved:

    // Prepare the CURL request
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://app.jobnimbus.com/api1/contacts',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode(array(
        "first_name" => $customerFirst,
        "last_name" => $customerLast,
        "Location" => $location,
        "sales_rep_name" => $consultant,
        "record_type_name" => $recType,
        "Appt Setter" => $setter,
        "status_name" => "Job Sold",
        "zip" => $zip,
        "city" => $city,
        "state_text" => $state,
        "home_phone" => $phone,
        "email" => $email,
        "Sales Rep Email" => $salesRepEmail,
        "address_line1" => $address,
        "sales_rep_name" => $salesRep,
        "Payment Method" => $paymentMethod,
        "Utility Account #" => $utilityAccount,
        "Payment Type" => $paymentType,
        "Tier 2 Sale" => $tier2,
        "Tier 2 Insurance Received" => "No",
        "Power Company" => $utility,
        "System Size (kW)" => $systemSize,
        "Deal Amount (Gross)" => $loanAmount,
        "Loan Term" => $loanTerm,
        "Panel Make, Model, Watt, Amt" => $panelString . ' [' . $project['module_total_panels'] . ']',
        "Inverter Type/Size" => $inverterString,
        "Battery Quantity" => $batteryCount,
        "Battery Type" => $batteryType,
        "Lead Provider" => $leadProvider,
        "Deal Date" => $dealDate,
        "Company Appointment" => $companyAppointment,
        "HOA" => $HOA,
        "HOA Info" => $HOAInfo,
        "Deal Amount (Gross)" => $grossDeal,
        "Rebate (Gross)" => $rebateGross,
        "Sunnova?" => $sunnovaYN,
        "Ballasted Racking" => $ballastedRacking,
        "Ground Mount" => $groundMount,
        "MPU/ Elec Work Needed" => $MPU,
        "Roof Included" => $roofIncluded,
        "Roofing Company" => $roofingCompany,
        "HVAC" => $HVAC,
        "Generator" => $generator,
        "Referral" => $referral,
        "Referral Info" => $referralInfo,
        "Roof Type" => $roofType,
        "# of Stories" => $numStories,
        "Insulation Type" => $insulationType,
        "Main Breaker Rating" => $mainbreakerRating,
        "Main Breaker Location" => $breakerLocation,
        "description" => $checklistNotes,
        "Solar Insure" => "No",
        "Installer (In House / Partner)" => "Unknown",
        "HOA Approval Received" => "No",
        "Lender NTP Received?" => "No",
        "Spanish Speaking" => "No"
    )),
    CURLOPT_HTTPHEADER => array(
        'Authorization: bearer $jnapi',
        'Content-Type: application/json'
    )
));

*/
?>
