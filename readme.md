# Subcontractor Hub Data Integration

## Project Overview
This project is designed to capture data from the Subcontractor Hub and store it in an SQL database. The provided PHP script processes incoming JSON payloads, checks if a project already exists, and either updates the existing project or inserts a new project into the database. It also manages project stages and documents.

## Setup and Installation

### Prerequisites
- PHP 7.4 or later (8.2+ recommended)
- MySQL or MariaDB
- A web server (e.g., Apache or Nginx)

### Installation
1. Clone the repository:
    ```sh
    git clone https://github.com/saintpetejackboy/sch.git
    cd subcontractor-hub-integration
    ```

2. Install dependencies:
    ```sh
    composer install
    ```

3. Configure database connection:
    - Replace the `tyrael.php` file in `dbconn.php` with your $pdo-> initialization script or relevant environment variables. 

4. Deploy the PHP script:
    - Place the PHP script in your web server's document root or a subdirectory as needed.

5. Ensure your web server has the necessary permissions to execute the script and access the database.

## Usage
To use this integration, send a JSON payload to the endpoint where the PHP script is hosted. The payload should follow the structure expected by the script. Included is a "testPayload.php" file that performs just this action. 

### Example Payload
```json
{
"event": "project.created",
"data": {
"external_id": null,
"job_type": "Solar",
"street": "3901 Marshall Street",
"city": "Dallas",
"state": "Texas",
"county": null,
"postal_code": "75210",
"country": "United States",
"territory": "Texas, TX",
"latitude": 32.76855,
"longitude": -96.745615,
"downpayment": 0,
"discounts_total": 500,
"base_system_cost": 11492,
"battery_total": 12500,
"adders_total": 65,
"dealer_fee": 0,
"annual_usage": 17261,

"stages": [
{
"label": "Site Survey Attachment",
"field_key": "site_survey_attachment",
"type": "file",
"value": null
},
{
"label": "Site Survey Complete",
"field_key": "site_survey_complete",
"type": "date_time",
"value": null
},
{
"label": "Site Survey Notes",
"field_key": "site_survey_notes",
"type": "text_area",
"value": null
},
{
"label": "Site Survey Returned",
"field_key": "site_survey_returned",

"type": "text",
"value": null
},
{
"label": "Site Survey Schedule",
"field_key": "site_survey_schedule",
"type": "date_time",
"value": null
},
{
"label": "Design Attachment",
"field_key": "design_attachment",
"type": "file",
"value": null
},
{
"label": "Design Complete",
"field_key": "design_complete",
"type": "date_time",
"value": null
},
{

"label": "Design Start",
"field_key": "design_start",
"type": "date_time",
"value": null
},
{
"label": "Meter Spot Request",
"field_key": "meter_spot_request",
"type": "date_time",
"value": null
},
{
"label": "NTP Complete",
"field_key": "ntp_complete",
"type": "date_time",
"value": null
},
{
"label": "Plancheck Completed",
"field_key": "plancheck_completed",
"type": "date_time",
"value": null

},
{
"label": "True Up Completed",
"field_key": "true_up_completed",
"type": "date_time",
"value": null
},
{
"label": "Permit Receive",
"field_key": "permit_receive",
"type": "text",
"value": null
},
{
"label": "Permit Request",
"field_key": "permit_request",
"type": "text",
"value": null
},
{
"label": "Permitting Attachment",
"field_key": "permitting_attachment",

"type": "file",
"value": null
},
{
"label": "Permitting Notes",
"field_key": "permitting_notes",
"type": "text_area",
"value": null
},
{
"label": "Final Inspection Passed",
"field_key": "final_inspection_passed",
"type": "date_time",
"value": null
},
{
"label": "Install Attachment",
"field_key": "install_attachment",
"type": "file",
"value": null
},
{

"label": "Install Completed",
"field_key": "install_completed",
"type": "date_time",
"value": null
},
{
"label": "Install Notes",
"field_key": "install_notes",
"type": "text_area",
"value": null
},
{
"label": "Install Scheduled Date",
"field_key": "install_scheduled_date",
"type": "date_time",
"value": null
},
{
"label": "Install Start Date",
"field_key": "install_start_date",
"type": "date_time",
"value": null

},
{
"label": "MPU Complete",
"field_key": "mpu_complete",
"type": "date_time",
"value": null
},
{
"label": "MPU Schedule",
"field_key": "mpu_schedule",
"type": "date_time",
"value": null
},
{
"label": "Photos Received",
"field_key": "photos_received",
"type": "date_time",
"value": null
},
{
"label": "Final Inspection Passed",
"field_key": "final_inspection_passed",

"type": "date_time",
"value": null
},
{
"label": "Inspection Completed",
"field_key": "inspection_completed",
"type": "date_time",
"value": null
},
{
"label": "Inspection Scheduled Date",
"field_key": "inspection_scheduled_date",
"type": "date_time",
"value": null
},
{
"label": "Inspection Start Date",
"field_key": "inspection_start_date",
"type": "date_time",
"value": null
},
{

"label": "Inspection Scheduled Date",
"field_key": "inspection_scheduled_date",
"type": "date_time",
"value": null
},
{
"label": "Monitoring Completed",
"field_key": "monitoring_completed",
"type": "date_time",
"value": null
},
{
"label": "PTO Attachment",
"field_key": "pto_attachment",
"type": "file",
"value": null
},
{
"label": "PTO Notes",
"field_key": "pto_notes",
"type": "text_area",
"value": null

},
{
"label": "PTO Receive",
"field_key": "pto_receive",
"type": "date_time",
"value": null
},
{
"label": "PTO Request",
"field_key": "pto_request",
"type": "date_time",
"value": null
},
{
"label": "Escalations",
"field_key": "escalations",
"type": "checkbox",
"value": null
},
{
"label": "Escalations Reason 1",
"field_key": "escalations_reason_1",

"type": "dropdown",
"value": null,
"options": null
},
{
"label": "Escalations Reason 2",
"field_key": "escalations_reason_2",
"type": "dropdown",
"value": null,
"options": null
},
{
"label": "Escalations Reason 3",
"field_key": "escalations_reason_3",
"type": "dropdown",
"value": null,
"options": null
},
{
"label": "Agent Job Status",
"field_key": "agent_job_status",
"type": "dropdown",

"value": null,
"options": null
},
{
"label": "Cancel Date",
"field_key": "cancel_date",
"type": "date_time",
"value": null
},
{
"label": "Cancellation Notes",
"field_key": "cancellation_notes",
"type": "text_area",
"value": null
},
{
"label": "Cancellation Reason",
"field_key": "cancellation_reason",
"type": "dropdown",
"value": null,
"options": null
},

{
"label": "Cancellation Sub Reason",
"field_key": "cancellation_sub_reason",
"type": "dropdown",
"value": null,
"options": null
},
{
"label": "Date Requested",
"field_key": "date_requested",
"type": "date_time",
"value": null
},
{
"label": "Live Transfer?",
"field_key": "live_transfer",
"type": "dropdown",
"value": null,
"options": null
},
{
"label": "Pending Cancel Date",

"field_key": "pending_cancel_date",
"type": "date_time",
"value": null
},
{
"label": "Pending Resolution Date",
"field_key": "pending_resolution_date",
"type": "date_time",
"value": null
},
{
"label": "Re-Save",
"field_key": "re_save",
"type": "checkbox",
"value": null
},
{
"label": "Re-Save Date",
"field_key": "re_save_date",
"type": "date_time",
"value": null
},

{
"label": "Retention Assigned To",
"field_key": "retention_assigned_to",
"type": "text",
"value": null
},
{
"label": "Retention Base Reason",
"field_key": "retention_base_reason",
"type": "text",
"value": null
},
{
"label": "Retention Set Date",
"field_key": "retention_set_date",
"type": "date_time",
"value": null
},
{
"label": "Retention Specific Reason",
"field_key": "retention_specific_reason",
"type": "text",

"value": null
},
{
"label": "Save Type",
"field_key": "save_type",
"type": "dropdown",
"value": null,
"options": [
{
"label": "None",
"value": "None"
},
{
"label": "Passive $100",
"value": "Passive $100"
},
{
"label": "Active $350",
"value": "Active $350"
}
]
},

{
"label": "Saved",
"field_key": "saved",
"type": "checkbox",
"value": null
},
{
"label": "Saved Date",
"field_key": "saved_date",
"type": "date_time",
"value": null
},
{
"label": "Setter Assigned To",
"field_key": "setter_assigned_to",
"type": "text",
"value": null
},
{
"label": "Setter Job Status",
"field_key": "setter_job_status",
"type": "dropdown",

"value": null,
"options": null
},
{
"label": "NTP Invoice Sent (CASH)",
"field_key": "ntp_invoice_sent_cash",
"type": "date_time",
"value": null
},
{
"label": "NTP Payment Received (CASH)",
"field_key": "ntp_payment_received_cash",
"type": "date_time",
"value": null
},
{
"label": "Funding Requested (Finance)",
"field_key": "funding_requested_finance_",
"type": "date_time",
"value": null
},
{

"label": "Funding Approved (Finance)",
"field_key": "funding_approved_finance_",
"type": "date_time",
"value": null
},
{
"label": "Customer Planset Approval Sent",
"field_key": "customer_planset_approval_sent",
"type": "date_time",
"value": null
},
{
"label": "Customer Planset Approved",
"field_key": "customer_planset_approved",
"type": "date_time",
"value": null
}
],
"subhub_id": 8024,
"contract_amount": 23557,
"utility_company": "Oncor Electric Delivery Company, LLC",
"utility_bill": 3055,

"module_name": "ZNshine",
"module_manufacturer": "ZNShine Solar",
"module_watts": 400,
"module_description": null,
"module_total_panels": 13,
"inverter_name": "DS3-S",
"inverter_manufacturer": "AP Systems",
"inverter_quantity": 1,
"battery_name": "AP Storage",
"battery_manufacturer": "AP Systems",
"battery_price": 12500,
"battery_size_kwh": 5.76,
"battery_quantity": 1,
"annual_production": 6840.848,
"finance_type": "CASH",
"contract_type": "Cash",
"finance_partner": null,
"finance_term_year": 0,
"finance_rate": 0,
"finance_escalator_rate": 0,
"finance_ppw": 0,
"finance_monthly_payment": 0,

"first_name": "Testing",
"last_name": "Integrations",
"name": "Testing Integrations",
"email": "renee@testing.com",
"phone": "+1 9162222220",
"owner_email": "bob.harmon@infinitysolarusa.com",
"documents": [
{
"url":

"https://stp-sales-tool.s3.us-west-2.amazonaws.com/projects/8024/attachmen
ts/v3ou2Gp5mCK89k7DNvcnGKBc1irvebFjF5i4avHi.png",

"label": "Design"
},
{
"url":

"https://stp-sales-tool.s3.us-west-2.amazonaws.com/proposals/46971/shadere
ports/shadereport-46971.pdf",
"label": "Shade Report"
},
{
"url":

"https://stp-sales-tool.s3.us-west-2.amazonaws.com/proposals/46971/product
iongraphs/production-graph-46971.pdf",
"label": "Production Graph"
}

],
"proposal_url":
"https://app.subcontractorhub.com/public-proposal/62918b59-69ef-47dc-b9b8-
b594670225c6",
"contract_signed_url": null,
"system_size_kw": 5.2,
"system_size_w": 5200,
"sales_representative_name": null,
"sales_representative_email": null
}
}
```

## Contributing
Contributions are welcome! Please open an issue or submit a pull request for any improvements or bug fixes.

## License
Definitely not suspended, revoked or expired!
```
