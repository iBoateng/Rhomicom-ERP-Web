<?php

$dfltPrvldgs = array("View System Administration", "View Users & their Roles",
    /* 2 */ "View Roles & their Priviledges", "View Registered Modules & their Priviledges",
    /* 4 */ "View Security Policies", "View Server Settings", "View User Logins",
    /* 7 */ "View Audit Trail Tables", "Add New Users & their Roles", "Edit Users & their Roles",
    /* 10 */ "Add New Roles & their Priviledges", "Edit Roles & their Priviledges",
    /* 12 */ "Add New Security Policies", "Edit Security Policies", "Add New Server Settings",
    /* 15 */ "Edit Server Settings", "Set manual password for users",
    /* 17 */ "Send System Generated Passwords to User Mails",
    /* 18 */ "View SQL", "View Record History", "Add/Edit Extra Info Labels", "Delete Extra Info Labels",
    /* 22 */ "Add Notices", "Edit Notices", "Delete Notices", "View Notices Admin");

$sysLovs = array("Benefits Types", "Relationship Types"
    , "Person Types-Further Details", "Countries", "Currencies", "Organisation Types"
    , "Divisions or Group Types", "Person Type Change Reasons", "Person Types"
    , "Qualification Types", "National ID Types", "Pay Frequencies",
    "Benefits & Dues/Contributions Value Types", "Extra Information Labels",
    "Divisions Images Directory", "Organization Images Directory", "Person Images Directory"
    , "Organisations", "Divisions/Groups", "Jobs", "Chart of Accounts",
    /* 21 */ "Transaction Accounts", "Parent Accounts", "Active Users", "Person Titles",
    "Gender", "Marital Status", "Nationalities", "Active Persons", "Sites/Locations",
    "Grades", "Positions", "Asset Accounts", "Expense Accounts", "Revenue Accounts",
    "Liability Accounts", "Equity Accounts", "Pay Items", "Pay Item Values",
    "Working Hours", "Gathering Types", "Organisational Pay Scale",
    "Transactions Date Limit 1", "Transactions Date Limit 2",
    "Budget Accounts", "Banks", "Bank Branches", "Bank Account Types", "Balance Items",
    "Non-Balance Items", "Person Sets for Payments", "Item Sets for Payments",
    "Audit Logs Directory", /* 53 */ "Reports Directory", "System Modules",
    "LOV Names", "User Roles", "Pay Item Classifications", "System Priviledges",
    /* 59 */ "Payment Means", "Allowed IP Address for Request Listener",
    /* 61 */ "CV Courses", "Schools/Academic Institutions", "Other Locations",
    /* 64 */ "Jobs/Professions/Occupations", "Certificate Names", "Languages",
    /* 67 */ "Hobbies", "Interests", "Conduct", "Attitudes",
    /* 71 */ "Companies/Work Places", "Customized Module Names", "Allowed Person Types for Roles",
    /* 74 */ "Document Signatory Columns", "Attachment Document Categories",
    /* 76 */ "Types of Incorporation", "List of Professional Services", "Grade Names", "Schools/Organisations/Institutions",
    /* 80 */ "Account Classifications", "Employer's File No.", "Person's Email Addresses",
    /* 83 */ "SMS API Parameters", "Universal Resource Locators (URLs)", "Asset Register",
    /* 86 */ "Audit Trail Trackable Actions");
$sysLovsDesc = array("Benefits Types", "Relationship Types"
    , "Further Details about the available person types", "Countries", "Currencies", "Organisation Types"
    , "Divisions or Group Types", "Person Type Change Reasons", "Person Types"
    , "Qualification Types", "National ID Types", "Pay Frequencies",
    "Benefits & Dues/Contributions Value Types", "Extra Information Labels",
    "Directory for keeping images from the div_groups_table",
    "Directory for keeping images coming from the org_details_table",
    "Directory for Storing Person's Images",
    "List of all organizations stored in the system",
    "List of all divisions/groups stored in the system",
    "List of all Jobs stored in the system",
    "List of all Accounts stored in the system",
    "List of all accounts transactions can be posted into",
    "List of all Parent Accounts in the system",
    "List of all users in the system",
    "Name Titles of Organization Persons", "Gender",
    "Marital Status", "Nationalities", "Active Persons",
    "List of all Sites/Locations", "List of all Grades",
    "List of all Positions", "Asset Accounts", "Expense Accounts",
    "Revenue Accounts", "Liability Accounts", "Equity Accounts",
    "Pay Items", "Pay Item Values", "Working Hours", "Gathering Types",
    "Organisational Pay Scale", "Transactions Date Limit 1",
    "Transactions Date Limit 2", "Budget Accounts", "Banks",
    "Bank Branches", "Bank Account Types", "Balance Items",
    "Non-Balance Items", "Person Sets for Payments",
    "Item Sets for Payments",
    "Audit Logs Directory", "Reports Directory", "System Modules", "LOV Names", "User Roles",
    "Pay Item Classifications", "System Priviledges", "Various Payment Means", "Allowed IP Address for Request Listener",
    /* 61 */ "CV Courses", "Schools/Academic Institutions", "Other Locations",
    /* 64 */ "Jobs/Professions/Occupations", "Certificate Names", "Languages",
    /* 67 */ "Hobbies", "Interests", "Conduct", "Attitudes",
    /* 71 */ "Companies/Work Places", "Customized Module Names", "Allowed Person Types for Roles",
    /* 74 */ "Document Signatory Columns", "Attachment Document Categories",
    /* 76 */ "Types of Incorporation", "List of Professional Services", "Grade Names", "Schools/Organisations/Institutions",
    /* 80 */ "Account Classifications", "Employer's File No.", "Person's Email Addresses",
    /* 83 */ "SMS API Parameters", "Universal Resource Locators (URLs)", "Asset Register",
    /* 86 */ "Audit Trail Trackable Actions");
$sysLovsDynQrys = array("", ""
    , "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",
    "select distinct trim(to_char(org_id,'999999999999999999999999999999')) a, org_name b, '' c from org.org_details order by 2",
    "select distinct trim(to_char(div_id,'999999999999999999999999999999')) a, div_code_name b, '' c, org_id d from org.org_divs_groups order by 2",
    "select distinct trim(to_char(job_id,'999999999999999999999999999999')) a, job_code_name b, '' c, org_id d from org.org_jobs order by 2",
    "select distinct trim(to_char(accnt_id,'999999999999999999999999999999')) a, accnt_num || '.' || accnt_name b, '' c, org_id d, accnt_num e from accb.accb_chart_of_accnts order by accnt_num",
    "select distinct trim(to_char(accnt_id,'999999999999999999999999999999')) a, (CASE WHEN prnt_accnt_id>0 THEN accnt_num || '.' || accnt_name || ' ('|| accb.get_accnt_num(prnt_accnt_id)||'.'||accb.get_accnt_name(prnt_accnt_id)|| ')' WHEN control_account_id>0 THEN accnt_num || '.' || accnt_name || ' ('|| accb.get_accnt_num(control_account_id)||'.'||accb.get_accnt_name(control_account_id)|| ')' ELSE accnt_num || '.' || accnt_name END) b, '' c, org_id d, accnt_num e from accb.accb_chart_of_accnts where (is_prnt_accnt = '0' and is_enabled = '1' and is_net_income = '0' and has_sub_ledgers = '0') order by accnt_num",
    "select distinct trim(to_char(accnt_id,'999999999999999999999999999999')) a, accnt_num || '.' || accnt_name b, '' c, org_id d, accnt_type e, accnt_num f from accb.accb_chart_of_accnts where (is_prnt_accnt = '1') order by accnt_num",
    "select distinct trim(to_char(user_id,'999999999999999999999999999999')) a, user_name b, '' c FROM sec.sec_users WHERE (now() between to_timestamp(valid_start_date,'YYYY-MM-DD HH24:MI:SS') AND " +
    "to_timestamp(valid_end_date,'YYYY-MM-DD HH24:MI:SS')) order by 1", "", "", "", "",
    "SELECT distinct local_id_no a, trim(title || ' ' || sur_name || " +
    "', ' || first_name || ' ' || other_names) b, '' c, org_id d " +
    "FROM prs.prsn_names_nos a order by local_id_no DESC",
    "select distinct trim(to_char(location_id,'999999999999999999999999999999')) a, location_code_name b, '' c, org_id d from org.org_sites_locations order by 2",
    "select distinct trim(to_char(grade_id,'999999999999999999999999999999')) a, grade_code_name b, '' c, org_id d from org.org_grades order by 2",
    "select distinct trim(to_char(position_id,'999999999999999999999999999999')) a, position_code_name b, '' c, org_id d from org.org_positions order by 2",
    "select distinct trim(to_char(accnt_id,'999999999999999999999999999999')) a, accnt_num || '.' || accnt_name b, '' c, org_id d, accnt_num e from accb.accb_chart_of_accnts where (accnt_type = 'A' and is_prnt_accnt = '0' and is_enabled = '1' and  is_retained_earnings= '0' and is_net_income = '0' and has_sub_ledgers = '0') order by accnt_num",
    "select distinct trim(to_char(accnt_id,'999999999999999999999999999999')) a, accnt_num || '.' || accnt_name b, '' c, org_id d, accnt_num e from accb.accb_chart_of_accnts where (accnt_type = 'EX' and is_prnt_accnt = '0' and is_enabled = '1' and  is_retained_earnings= '0' and is_net_income = '0' and has_sub_ledgers = '0') order by accnt_num",
    "select distinct trim(to_char(accnt_id,'999999999999999999999999999999')) a, accnt_num || '.' || accnt_name b, '' c, org_id d, accnt_num e from accb.accb_chart_of_accnts where (accnt_type = 'R' and is_prnt_accnt = '0' and is_enabled = '1' and  is_retained_earnings= '0' and is_net_income = '0' and has_sub_ledgers = '0') order by accnt_num",
    "select distinct trim(to_char(accnt_id,'999999999999999999999999999999')) a, accnt_num || '.' || accnt_name b, '' c, org_id d, accnt_num e from accb.accb_chart_of_accnts where (accnt_type = 'L' and is_prnt_accnt = '0' and is_enabled = '1' and  is_retained_earnings= '0' and is_net_income = '0' and has_sub_ledgers = '0') order by accnt_num",
    "select distinct trim(to_char(accnt_id,'999999999999999999999999999999')) a, accnt_num || '.' || accnt_name b, '' c, org_id d, accnt_num e from accb.accb_chart_of_accnts where (accnt_type = 'EQ' and is_prnt_accnt = '0' and is_enabled = '1' and  is_retained_earnings= '0' and is_net_income = '0' and has_sub_ledgers = '0') order by accnt_num",
    "select distinct trim(to_char(item_id,'999999999999999999999999999999')) a, item_code_name b, '' c, org_id d from org.org_pay_items order by 2",
    "select distinct trim(to_char(pssbl_value_id,'999999999999999999999999999999')) a, pssbl_value_code_name b, '' c, item_id d from org.org_pay_items_values order by 2",
    "select distinct trim(to_char(work_hours_id,'999999999999999999999999999999')) a, work_hours_name b, '' c, org_id d from org.org_wrkn_hrs order by 2",
    "select distinct trim(to_char(gthrng_typ_id,'999999999999999999999999999999')) a, gthrng_typ_name b, '' c, org_id d from org.org_gthrng_types order by 2",
    "", "", "",
    "select distinct trim(to_char(accnt_id,'999999999999999999999999999999')) a, accnt_num || '.' || accnt_name b, '' c, org_id d, accnt_num e from accb.accb_chart_of_accnts where ((accnt_type = 'R' or accnt_type = 'EX') and is_prnt_accnt = '0' and is_enabled = '1' and has_sub_ledgers = '0') order by accnt_num", "", "", "",
    "select distinct trim(to_char(item_id,'999999999999999999999999999999')) a, item_code_name b, '' c, org_id d from org.org_pay_items where item_maj_type = 'Balance Item' order by item_code_name",
    "select distinct trim(to_char(item_id,'999999999999999999999999999999')) a, item_code_name b, '' c, org_id d, pay_run_priority e from org.org_pay_items where item_maj_type = 'Pay Value Item' order by pay_run_priority",
    "select distinct trim(to_char(prsn_set_hdr_id,'999999999999999999999999999999')) a, prsn_set_hdr_name b, '' c, org_id d from pay.pay_prsn_sets_hdr order by prsn_set_hdr_name",
    "select distinct trim(to_char(hdr_id,'999999999999999999999999999999')) a, itm_set_name b, '' c, org_id d from pay.pay_itm_sets_hdr order by itm_set_name"
    , "", "", "select distinct trim(to_char(module_id,'999999999999999999999999999999')) a, module_name b, '' c from sec.sec_modules order by module_name"
    , "select distinct trim(to_char(value_list_id,'999999999999999999999999999999')) a, value_list_name b, '' c from gst.gen_stp_lov_names order by value_list_name"
    , "select distinct trim(to_char(role_id,'999999999999999999999999999999')) a, role_name b, '' c from sec.sec_roles order by role_name", "",
    "select distinct trim(to_char(prvldg_id,'999999999999999999999999999999')) a, prvldg_name || ' (' || sec.get_module_nm(module_id) || ')' b, '' c, prvldg_id d from sec.sec_prvldgs order by prvldg_id", "", "",
    /* 61 */ "", "", "",
    /* 64 */ "", "", "",
    /* 67 */ "", "", "", "",
    /* 71 */ "", "", "", "", "", "", "",
    /* 78 */ "select distinct grade_code_name a, grade_code_name b, '' c, org_id d from org.org_grades order by 1",
    /* 79 */ "",
    /* 80 */ "", "",
    "SELECT distinct REPLACE(email,',',';') a, trim(title || ' ' || sur_name || " +
    "', ' || first_name || ' ' || other_names || ' ('||local_id_no||')') b, '' c, org_id d, local_id_no e " +
    "FROM prs.prsn_names_nos a order by local_id_no",
    /* 83 */ "", "",
    "Select '' || asset_id a, asset_code_name || ':' || asset_desc || ':' || asset_classification || ':' ||asset_category || ':' || tag_number b, '' c, org_id d from accb.accb_fa_assets_rgstr order by 2",
    /* 86 */ "");

$pssblVals = array("0", "Loans",
    "Money amounts granted to staff to be paid later"
    , "0", "Allowances", "Money amounts granted to staff"
    , "0", "Leave", "Vacation Days allowed for employees"
    , "1", "Father", "Biological Male Parent"
    , "1", "Mother", "Biological Female Parent"
    , "1", "Spouse", "Husband or Wife"
    , "1", "Ex-Spouse", "Former Husband or wife"
    , "1", "Son", "Biological Male Child"
    , "1", "Daughter", "Biological Female Child"
    , "1", "Uncle", "Uncle"
    , "1", "Aunt", "Aunt"
    , "1", "Nephew", "Nephew"
    , "1", "Niece", "Niece"
    , "1", "In-Law", "In-Law"
    , "1", "Cousin", "Cousin"
    , "1", "Friend", "Friend"
    , "1", "Guardian", "Guardian"
    , "1", "Grand-Father", "Grand-Father"
    , "1", "Grand-Mother", "Grand-Mother"
    , "1", "Step-Father", "Step-Father"
    , "1", "Step-Mother", "Step-Mother"
    , "1", "Step-Son", "Step-Son"
    , "1", "Step-Daughter", "Step-Daughter"
    , "2", "Permanent-Full Time", "Full Time permanent staff"
    , "2", "Permanent-Part Time", "Part Time permanent staff"
    , "2", "Contract-Full Time", "Full Time contract staff"
    , "2", "Contract-Part Time", "Part Time contract staff"
    , "3", "Ghana", "GH"
    , "3", "South Africa", "SA"
    , "3", "United States of America", "USA"
    , "3", "United Kingdom", "UK"
    , "4", "GHS", "Ghana Cedis ₵"
    , "4", "JPY", "Japanese Yen ¥"
    , "4", "USD", "US Dollars $"
    , "4", "GBP", "British Pound £"
    , "5", "School", "Place of tution and learning"
    , "5", "Hotel", "Place where rooms are hired out to the public"
    , "5", "Church", "Place of Worship"
    , "5", "NGO", "Non-Governmental Organization"
    , "5", "Company", "Company"
    , "5", "Super Market", "Super Market"
    , "5", "Mini Mart", "Mini Mart"
    , "5", "Shop/Store", "Shop/Store"
    , "5", "Boutique", "Boutique"
    , "6", "Office", "Major Division under Department"
    , "6", "Unit", "Division under Office"
    , "6", "Department", "Major Division in an Organization"
    , "6", "Wing", "Typically in churchs"
    , "6", "Club", "Association"
    , "6", "Association", "Welfare Group"
    , "6", "Religious Denomination", "Religious group"
    , "6", "Team", "Group for competitions"
    , "6", "Shareholders", "Group for Shareholders"
    , "6", "Board of Directors", "Group for Board of Directors"
    , "6", "Pay/Remuneration", "Group for Workers' Salaries/Wages"
    , "6", "Top Management", "Group for Top Management"
    , "7", "New Shareholder", "New Shareholder"
    , "7", "Starting Director/Shareholder", "Starting Director/Shareholder"
    , "7", "New Recruitment", "New staff"
    , "7", "Re-Employment", "Old staff coming back"
    , "7", "New Enrolment", "New Member"
    , "7", "Re-Enrolment", "Old Member coming back"
    , "7", "End of Contract", "Contract has ended duely"
    , "7", "Appointment as Board Member", "Appointment as Board Member"
    , "7", "Termination of Appointment", "Appointment Terminated"
    , "7", "Dismissal", "Sacked"
    , "7", "Compulsory Retirement", "Reached age Limit"
    , "7", "Voluntary Retirement", "Decided to retire early"
    , "7", "Retirement on Medical Grounds", "Retiring due to Ailment"
    , "7", "Change of Membership Terms", "Change of Membership Terms"
    , "7", "Change of Employement Terms", "Change of Employement Terms"
    , "8", "Shareholder", "Owner of Shares in the Company"
    , "8", "Board Member", "Member of Board of Directors"
    , "8", "Contact Person", "Relative or Friend"
    , "8", "Ex-Contact Person", "Former Relative or Friend"
    , "8", "Customer", "Client"
    , "8", "Ex-Customer", "Former Client"
    , "8", "Supplier", "Supplier of goods and services"
    , "8", "Ex-Supplier", "Former Supplier of goods and services"
    , "8", "Ex-Customer", "Former Client"
    , "8", "Student", "Currently a Student"
    , "8", "Old Student", "Former Student"
    , "8", "Employee", "Currently a worker"
    , "8", "Ex-Employee", "Former Worker"
    , "8", "Member", "Currently a Member of the group"
    , "8", "Ex-Member", "A Former Member of the group"
    , "9", "1st Degree", "First Degree University"
    , "9", "2nd Degree", "Second Degree University"
    , "9", "Form 5", "Senior Secondary School Cert.(O-Level)"
    , "9", "Sixth Form", "Senior Secondary School Cert.(A-Level)"
    , "9", "Senior High", "Senior High School Cert.(WASSCE)"
    , "9", "Junior High", "Junior High School Cert.(BECE)"
    , "9", "Phd", "Doctor of Philosophy"
    , "10", "NHIS ID", "Health Insurance"
    , "10", "Voter's ID", "Voter's ID Card"
    , "10", "Driving License", "Driver's License"
    , "10", "Passport", "Passport"
    , "10", "SSNIT", "SSNIT"
    , "11", "fixed", "for payments at end of contracts"
    , "11", "hourly", "hourly"
    , "11", "daily", "daily"
    , "11", "weekly", "weekly"
    , "11", "fortnightly", "fortnightly"
    , "11", "semi-month", "semi-month"
    , "11", "month", "month"
    , "11", "yearly", "yearly"
    , "11", "quaterly", "quaterly"
    , "12", "Money", "Money"
    , "12", "Items", "Items"
    , "12", "Service", "Service"
    , "12", "Working Days", "Working Days"
    , "13", "Motto", "Motto of a Group/Division"
    , "13", "Mission", "Mission of a Group/Division"
    , "13", "Vision", "Vision of a Group/Division"
    , "24", "Mr.", "Mr."
    , "24", "Mrs.", "Mrs."
    , "24", "Master", "Master"
    , "24", "Ms.", "Ms."
    , "24", "Miss.", "Miss."
    , "24", "Dr.", "Dr."
    , "24", "Prof.", "Prof."
    , "25", "Male", "Male"
    , "25", "Female", "Female"
    , "25", "Not Applicable", "Not Applicable"
    , "26", "Single", "Single"
    , "26", "Married", "Married"
    , "26", "Divorced", "Divorced"
    , "26", "Separated", "Separated"
    , "26", "Widow", "Widow"
    , "26", "Widower", "Widower"
    , "27", "Ghanaian", "Ghanaian"
    , "27", "American", "American"
    , "27", "British", "British"
    , "27", "Togolese", "Togolese"
    , "41", "2400", "9999.Rhomicom Basic Worker Grade.P1"
    , "41", "3000", "9999.Rhomicom Basic Worker Grade.P2"
    , "42", "01-JAN-1900 00:00:00", "01-JAN-1900"
    , "43", "31-DEC-4000 23:59:59", "31-DEC-4000"
    , "45", "Bank of Ghana", "Bank of Ghana"
    , "45", "Barclays Bank", "Barclays Bank"
    , "45", "Standard Chartered Bank", "Standard Chartered Bank"
    , "45", "Ghana Commercial Bank", "Ghana Commercial Bank"
    , "45", "Prudential Bank", "Prudential Bank"
    , "46", "Accra Branch", "Accra Branch"
    , "46", "Makola Branch", "Makola Branch"
    , "46", "Ring Road Branch", "Ring Road Branch"
    , "46", "Kaneshie Branch", "Kaneshie Branch"
    , "46", "KNUST Branch", "KNUST Branch"
    , "47", "Current Account", "Kaneshie Branch"
    , "47", "Savings Account", "KNUST Branch"
    , "57", "Payslip Item", "Payslip Items-Items that appear on Payslip after during payroll run"
    , "57", "Payroll Item", "Payroll Items-Items Run during payroll run but don't appear on Payslip"
    , "57", "Bill Item", "Bill Items Eg. School Fees Bill Items"
    , "57", "Balance Item", "Balance Items Eg. TAKE HOME PAY"
    , "59", "Cash Cheque", "Cash Cheque"
    , "59", "Clearing Cheque", "Clearing Cheque"
    , "59", "Payment Order", "Payment Order"
    , "59", "Visa Card", "Visa Card"
    , "59", "Mastercard", "Mastercard"
    , "59", "Ezwich", "Ezwich"
    , "59", "Visa Ghana", "Visa Ghana"
    , "59", "Paypal", "Paypal"
    , "59", "Mobile Money", "Mobile Money",
    "59", "Supplier Cheque", "Supplier Cheque",
    "59", "Supplier Cash", "Supplier Cash",
    "59", "Customer Cheque", "Customer Cheque",
    "59", "Customer Cash", "Customer Cash",
    "59", "Supplier Prepayment Application", "Supplier Prepayment Application",
    "59", "Customer Prepayment Application", "Customer Prepayment Application",
    "60", "192.168.0.100", "192.168.0.100",
    "60", "localhost", "localhost",
    "61", "Bsc. Computer Science", "Computer Science Degree",
    "61", "Bsc. Computer Engineering", "Computer Engineering Degree",
    "61", "B.E.C.E", "B.E.C.E",
    "61", "W.A.S.S.C.E", "W.A.S.S.C.E",
    "61", "S.S.C.E", "S.S.C.E",
    "61", "A-Level", "A-Level",
    "61", "O-Level", "O-Level",
    "62", "Kwame Nkrumah University of Science and Technology", "Tertiary",
    "62", "University of Ghana-Legon", "Tertiary",
    "62", "Prempeh College", "Secondary",
    "63", "Accra-Ghana", "Accra-Ghana",
    "63", "Kumasi-Ghana", "Kumasi-Ghana",
    "64", "Engineer", "Engineer",
    "64", "IT Technician", "IT Technician",
    "65", "B.E.C.E", "B.E.C.E",
    "65", "W.A.S.S.C.E", "W.A.S.S.C.E",
    "65", "S.S.C.E", "S.S.C.E",
    "65", "A-Level", "A-Level",
    "65", "O-Level", "O-Level",
    "65", "Bsc.", "Bachelor of Science",
    "65", "Msc.", "Master of Science",
    "65", "PhD", "Doctor of Philosophy",
    "66", "Twi", "Twi",
    "66", "English", "English",
    "67", "Playing Soccer", "Playing Soccer",
    "67", "Playing Lead Guitar", "Playing Lead Guitar",
    "68", "Singing", "Singing",
    "68", "Reading", "Reading",
    "69", "Calm", "Calm",
    "69", "Respectful", "Respectful",
    "70", "Hardworking", "Hardworking",
    "70", "Serious", "Serious",
    "71", "Rhomicom Systems Tech. Ltd.", "Rhomicom Systems Tech. Ltd.",
    "72", "Basic Person Data", "Personnel/ Membership Data",
    "72", "Internal Payments", "Personnel/ Membership Payments",
    "72", "Learning/Performance Management", "Performance Management System",
    "72", "Hospitality Management", "Hospitality Management",
    "72", "Events and Attendance", "Events and Attendance",
    "72", "Sales and Inventory", "Sales and Inventory",
    "72", "Project Management", "Projects Management",
    "73", "Basic Person Data Administrator", "'All'",
    "73", "Personnel Data Administrator", "'Employee','Staff'",
    "74", "Invoices Signatories", "                    Prepared By                    Authorized By                    Approved By",
    "74", "PO Signatories", "                    Prepared By                    Authorized By                    Approved By",
    "74", "Receipt Signatories", "                    Received By                    Inspected By                    Approved By",
    "74", "Receipt Return Signatories", "                    Returned By                    Authorized By                    Approved By",
    "74", "Payroll Signatories", "                    Prepared By                    Authorized By                    Approved By",
    "75", "Curriculum Vitae", "Curriculum Vitae",
    "75", "Membership Forms", "Membership Forms",
    "75", "Career Report", "Career Report",
    "75", "Other Information", "Other Information",
    "76", "Public Company Ltd", "Public Company Ltd",
    "76", "Private Company Ltd", "Private Company Ltd",
    "76", "Closed Corporation", "Closed Corporation",
    "76", "Joint Venture", "Joint Venture",
    "76", "Consortium", "Consortium",
    "76", "Partnership", "Partnership",
    "76", "Sole Proprietor", "Sole Proprietor",
    "76", "Foreign Company", "Foreign Company",
    "76", "Government/Parastatals", "Government/Parastatals",
    "76", "Trust", "Trust",
    "77", "Architecture", "Architecture",
    "77", "Surveying", "Surveying",
    "77", "Project Management", "Project Management",
    "77", "Planning", "Planning",
    "77", "Engineering", "Engineering",
    "79", "Kwame Nkrumah University of Science and Technology", "School",
    "79", "University of Ghana-Legon", "School",
    "79", "Prempeh College", "School",
    "79", "Rhomicom Systems Tech. Ltd.", "Company",
    "80", "Cash and Cash Equivalents", "Cash and Cash Equivalents",
    "80", "Operating Activities.Sale of Goods", "Operating Activities.Sale of Goods",
    "80", "Operating Activities.Sale of Services", "Operating Activities.Sale of Services",
    "80", "Operating Activities.Other Income Sources", "Operating Activities.Other Income Sources",
    "80", "Operating Activities.Cost of Sales", "Operating Activities.Cost of Sales",
    "80", "Operating Activities.Net Income", "Operating Activities.Net Income",
    "80", "Operating Activities.Depreciation Expense", "Operating Activities.Depreciation Expense",
    "80", "Operating Activities.Amortization Expense", "Operating Activities.Amortization Expense",
    "80", "Operating Activities.Gain on Sale of Equipment", "Operating Activities.Gain on Sale of Equipment"/* NEGATE */,
    "80", "Operating Activities.Loss on Sale of Equipment", "Operating Activities.Loss on Sale of Equipment",
    "80", "Operating Activities.Other Non-Cash Expense", "Operating Activities.Other Non-Cash Expense",
    "80", "Operating Activities.Accounts Receivable", "Operating Activities.Accounts Receivable"/* NEGATE */,
    "80", "Operating Activities.Bad Debt Expense", "Operating Activities.Bad Debt Expense"/* NEGATE */,
    "80", "Operating Activities.Prepaid Expenses", "Operating Activities.Prepaid Expenses"/* NEGATE */,
    "80", "Operating Activities.Inventory", "Operating Activities.Inventory"/* NEGATE */,
    "80", "Operating Activities.Accounts Payable", "Operating Activities.Accounts Payable",
    "80", "Operating Activities.Accrued Expenses", "Operating Activities.Accrued Expenses",
    "80", "Operating Activities.Taxes Payable", "Operating Activities.Taxes Payable",
    "80", "Operating Activities.Operating Expense", "Operating Activities.Operating Expense",
    "80", "Operating Activities.General and Administrative Expense", "Operating Activities.General and Administrative Expense",
    "80", "Investing Activities.Asset Sales/Purchases", "Investing Activities.Asset Sales/Purchases"/* NEGATE */,
    "80", "Investing Activities.Equipment Sales/Purchases", "Investing Activities.Equipment Sales/Purchases"/* NEGATE */,
    "80", "Financing Activities.Capital/Stock", "Financing Activities.Capital/Stock",
    "80", "Financing Activities.Long Term Debts", "Financing Activities.Long Term Debts",
    "80", "Financing Activities.Short Term Debts", "Financing Activities.Short Term Debts",
    "80", "Financing Activities.Equity Securities", "Financing Activities.Equity Securities",
    "80", "Financing Activities.Dividends Declared", "Financing Activities.Dividends Declared"/* NEGATE */,
    "80", "", "",
    "81", "TIN", "LEE 12345",
    "83", "url", "http://txtconnect.co/api/send/",
    "83", "token", "123456789",
    "83", "msg", "{:msg}",
    "83", "from", "Rhomicom",
    "83", "to", "{:to}",
    "84", "QR Code Validation URL", "https://www.rhomicomgh.com/index.php?id=",
    "86", "INSERT STATEMENTS", "INSERT STATEMENTS",
    "86", "UPDATE STATEMENTS", "UPDATE STATEMENTS",
    "86", "DELETE STATEMENTS", "DELETE STATEMENTS",
    "86", "INFO ON DATA VIEWED", "INFO ON DATA VIEWED"
);

$lvid = getLovID("Security Keys");
$apKey = getEnbldPssblValDesc(
        "AppKey", $lvid);
if ($apKey != "" && $lvid > 0) {
    $smplTokenWord = $apKey;
} else if ($lvid <= 0) {
    $apKey = "ROMeRRTRREMhbnsdGeneral KeyZzfor Rhomi|com Systems "
            . "Tech. !Ltd Enterpise/Organization @763542ERPorbjkSOFTWARE"
            . "asdbhi68103weuikTESTfjnsdfRSTLU../";
    $smplTokenWord = $apKey;
    createLovNm("Security Keys", "Security Keys", false, "", "SYS", true);
    $lvid = getLovID("Security Keys");
    if ($lvid > 0) {
        createPssblValsForLov($lvid, "AppKey", $apKey, true, get_all_OrgIDs());
    }
}

function encrypt1($inpt, $key) {
    try {
        $numChars = rand(1000, 5999);
        $numChars1 = rand(6000, 9000);
        $encrptdLen = str_pad(strlen($inpt) + $numChars, 4, "0", STR_PAD_LEFT);
        $encrptdLen1 = str_pad(strlen($inpt) + $numChars1, 4, "0", STR_PAD_LEFT);

        /* $numChars2 = rand(5, 9);
          $nwTxt = getRandomTxt($numChars);
          $nwTxt1 = getRandomTxt($numChars1);
          $nwTxt2 = getRandomTxt($numChars2);
          $expDate = str_replace(" ", "", getDB_Date_time()); */

        $inpt = $numChars . $encrptdLen . $inpt . $numChars1 . $encrptdLen1;
        $fnl_str = "";
        $charset1 = array(
            "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L",
            "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X",
            "Y", "Z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l",
            "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x",
            "y", "z");
        $charset2 = str_split(getNewKey($key), 1);
//exp
        $wldChars = array("`", "¬", "!", "\"", "£", "$", "%", "^", "&", "*", "(", ")",
            "-", "_", "=", "+", "{", "[", "]", "}", ":", ";", "@", "'",
            "#", "~", "/", "?", ">", ".", "<", ",", "\\", "|", " ");
        for ($i = strlen($inpt) - 1; $i >= 0; $i--) {
            $tst_str = substr($inpt, $i, 1);
            $j = findCharIndx($tst_str, $charset1);
            if ($j == -1) {
                $k = findCharIndx($tst_str, $wldChars);
                if ($k == -1) {
                    $fnl_str .= $tst_str;
                } else {
                    $fnl_str .= $charset2[$k] . "_";
                }
            } else {
                $fnl_str .= $charset2[$j];
            }
        }
        return $fnl_str;
    } catch (Exception $e) {
        return $inpt;
    }
}

function encrypt($inpt, $key) {
    try {
        $numChars = 5433; //rand(1000, 5999);
        $numChars1 = 8279; //(6000, 9000);
        $encrptdLen = str_pad(strlen($inpt) + $numChars, 4, "0", STR_PAD_LEFT);
        $encrptdLen1 = str_pad(strlen($inpt) + $numChars1, 4, "0", STR_PAD_LEFT);

        /* $numChars2 = rand(5, 9);
          $nwTxt = getRandomTxt($numChars);
          $nwTxt1 = getRandomTxt($numChars1);
          $nwTxt2 = getRandomTxt($numChars2);
          $expDate = str_replace(" ", "", getDB_Date_time()); */

        $inpt = $numChars . $encrptdLen . $inpt . $numChars1 . $encrptdLen1;
        $fnl_str = "";
        $charset1 = array(
            "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L",
            "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X",
            "Y", "Z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l",
            "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x",
            "y", "z");
        $charset2 = str_split(getNewKey($key), 1);
//exp
        $wldChars = array("`", "¬", "!", "\"", "£", "$", "%", "^", "&", "*", "(", ")",
            "-", "_", "=", "+", "{", "[", "]", "}", ":", ";", "@", "'",
            "#", "~", "/", "?", ">", ".", "<", ",", "\\", "|", " ");
        for ($i = strlen($inpt) - 1; $i >= 0; $i--) {
            $tst_str = substr($inpt, $i, 1);
            $j = findCharIndx($tst_str, $charset1);
            if ($j == -1) {
                $k = findCharIndx($tst_str, $wldChars);
                if ($k == -1) {
                    $fnl_str .= $tst_str;
                } else {
                    $fnl_str .= $charset2[$k] . "_";
                }
            } else {
                $fnl_str .= $charset2[$j];
            }
        }
        return $fnl_str;
    } catch (Exception $e) {
        return $inpt;
    }
}

function encrypt2($inpt, $key) {
    try {
        $numChars = 123456;
        $numChars1 = 789012;
        $encrptdLen = str_pad(strlen($inpt) + $numChars, 6, "0", STR_PAD_LEFT);
        $encrptdLen1 = str_pad(strlen($inpt) + $numChars1, 6, "0", STR_PAD_LEFT);

        $inpt = $numChars . $encrptdLen . $inpt . $numChars1 . $encrptdLen1;
        $fnl_str = "";
        $charset1 = array(
            "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L",
            "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X",
            "Y", "Z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l",
            "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x",
            "y", "z");
        $charset2 = str_split(getNewKey($key), 1);
        $wldChars = array("`", "¬", "!", "\"", "£", "$", "%", "^", "&", "*", "(", ")",
            "-", "_", "=", "+", "{", "[", "]", "}", ":", ";", "@", "'",
            "#", "~", "/", "?", ">", ".", "<", ",", "\\", "|", " ");
        for ($i = strlen($inpt) - 1; $i >= 0; $i--) {
            $tst_str = substr($inpt, $i, 1);
            $j = findCharIndx($tst_str, $charset1);
            if ($j == -1) {
                $k = findCharIndx($tst_str, $wldChars);
                if ($k == -1) {
                    $fnl_str .= $tst_str;
                } else {
                    $fnl_str .= $charset2[$k] . "_";
                }
            } else {
                $fnl_str .= $charset2[$j];
            }
        }
        return $fnl_str;
    } catch (Exception $e) {
        return $inpt;
    }
}

function getUserPswd($username) {
    $sqlStr = "select usr_password from sec.sec_users where lower(user_name) = lower('" .
            loc_db_escape_string($username) . "')";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return "";
}

function storeOldPassword($usrid, $pswd) {
    global $smplTokenWord;
    $dateStr = getDB_Date_time();
    $sqlStr = "INSERT INTO sec.sec_users_old_pswds(user_id, old_password, date_added) 
            VALUES (" . $usrid . ", md5('" . loc_db_escape_string(encrypt($pswd, $smplTokenWord)) .
            "'), '" . $dateStr . "')";
    executeSQLNoParams($sqlStr
    );
}

function isLoginInfoCorrct($usrname, $pswd) {
    global $smplTokenWord;
    $sqlStr = "SELECT user_id FROM sec.sec_users WHERE ((lower(user_name) = lower('" .
            loc_db_escape_string($usrname) .
            "')) AND (usr_password = md5('" . loc_db_escape_string(encrypt($pswd, $smplTokenWord)) .
            "')) AND (now() between to_timestamp(valid_start_date,'YYYY-MM-DD HH24:MI:SS') AND " .
            "to_timestamp(valid_end_date,'YYYY-MM-DD HH24:MI:SS')))";
    //var_dump($sqlStr);
    $result = executeSQLNoParams($sqlStr);
    if (loc_db_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function isPswdInRcntHstry($pswd, $usrid) {
// Checks whether the new password is in the past disllowed number of passwords
    global $smplTokenWord;
    $sqlStr = "SELECT a.old_pswd_id FROM 
    (SELECT old_pswd_id, old_password FROM sec.sec_users_old_pswds WHERE(user_id = " .
            $usrid . ") ORDER BY old_pswd_id DESC limit " . get_CurPlcy_DsllwdPswdCnt() .
            ") a WHERE(a.old_password = md5('" . loc_db_escape_string(encrypt($pswd, $smplTokenWord)) . "'))";
    $result = executeSQLNoParams($sqlStr);
    if (loc_db_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function checkNCreateUser($UNM, &$dsply) {
    global $usrID;
////Using Loc ID No.
//Check if username doesn't exist in sec but exists in prsn_names_nos
//Get Person ID if true and 
//Create this User Person

    $usr_Nm = $UNM;
    $nwPrsnID = getNewUserPrsnID($UNM);
    $oldUsrID = getUserID($usr_Nm);
    if ($nwPrsnID > 0) {
        $affctd = 0;
        $affctd1 = 0;
        //$prn_Nm = getPrsnFullNm($nwPrsnID);
        $prn_Loc_ID = $UNM;
        $start_date = date('d-M-Y H:i:s');
        $end_date = '31-Dec-4000 23:59:59';
        $datestr = getDB_Date_time();
        $slctdRoles = "-1;" . getRoleID('Self-Service (Standard)') . ";" . $start_date . ";" . $end_date . "|";
//exit();
        if ($usr_Nm == "" || $prn_Loc_ID == "" || $start_date == "" || $end_date == "") {
            $dsply = "Please fill all required fields!";
            return FALSE;
        } else if ($oldUsrID > 0) {
            $dsply = "New User Name($usr_Nm) is already in Use!";
            return FALSE;
        } else {
            $start_date = cnvrtDMYTmToYMDTm($start_date);
            $end_date = cnvrtDMYTmToYMDTm($end_date);
            $prsID = $nwPrsnID;
            $insSQL = "INSERT INTO sec.sec_users(
            user_name, usr_password, person_id, is_suspended, is_pswd_temp, 
            failed_login_atmpts, last_login_atmpt_time, last_pswd_chng_time, 
            valid_start_date, valid_end_date, created_by, creation_date, 
            last_update_by, last_update_date) 
            VALUES('" . loc_db_escape_string($usr_Nm) . "', '" . loc_db_escape_string($usr_Nm) .
                    "', $prsID, FALSE, TRUE, 0, '$datestr', '$datestr', '" . $start_date . "', '" . $end_date . "', 
                $usrID, '$datestr', $usrID, '" . $datestr . "')";
            $affctd = execUpdtInsSQL($insSQL);
        }

        if ($slctdRoles != "") {
            $usr_IDNo = getUserID($usr_Nm);
            $arry1 = explode('|', $slctdRoles);
            for ($i = 0; $i < count($arry1); $i++) {
                $arry2 = explode(';', $arry1[$i]);
                //var_dump($arry2);
                if ($arry2[0] == "") {
                    continue;
                }
                $usrRoleID = $arry2[0];
                $roleID = $arry2[1];
                $usrHasRole = FALSE;
                if ($roleID > 0 && $usr_IDNo > 0) {
                    $usrHasRole = doesUsrIDHvThsRoleID($usr_IDNo, $roleID);
                    $roleStrDte = cnvrtDMYTmToYMDTm($arry2[2]);
                    $roleEndDate = cnvrtDMYTmToYMDTm($arry2[3]);
                    if ($usrRoleID > 0) {
                        $updtSQL = "UPDATE sec.sec_users_n_roles
   SET role_id=$roleID, valid_start_date='$roleStrDte', valid_end_date='$roleEndDate', 
       last_update_by=$usrID, last_update_date='$datestr'
 WHERE dflt_row_id=$usrRoleID and user_id = $usr_IDNo";
                        $affctd1 += execUpdtInsSQL($updtSQL);
                    } else if ($usrHasRole == FALSE) {
                        $insSQL = "INSERT INTO sec.sec_users_n_roles(
            user_id, role_id, valid_start_date, valid_end_date, created_by, 
            creation_date, last_update_by, last_update_date)
    VALUES ($usr_IDNo, $roleID, '$roleStrDte', '$roleEndDate', 
            $usrID, '" . $datestr . "', $usrID, '" . $datestr . "');";
                        $affctd1 += execUpdtInsSQL($insSQL);
                    }
                }
            }
        }
        if ($affctd > 0) {
            $dsply .= "Successfully saved records of " . $usr_Nm;
            $dsply .= "<br/>$affctd1 User's Role(s) Assigned!<br/>";
            return TRUE;
        } else {
            return FALSE;
        }
    } else {
        if ($oldUsrID > 0) {
            
        } else {
            $dsply .= "<span style=\"color:red;\">User Name or ID No. does not exist!<br/></span>";
        }
        return FALSE;
    }
}

function changeUserPswd($usr_id, $pswd, $isTmp, $isAuto = 0) {
    global $smplTokenWord;
    if ($usr_id <= 0) {
        $usrID = $_SESSION['USRID'];
    } else {
        $usrID = $usr_id;
    }
    $dateStr = getDB_Date_time();
    $sqlStr = "UPDATE sec.sec_users SET usr_password = md5('" . loc_db_escape_string(encrypt($pswd, $smplTokenWord)) .
            "'), last_pswd_chng_time = '" . $dateStr . "', is_pswd_temp = $isTmp, last_update_by = " .
            $usrID . ", last_update_date = '" . $dateStr . "', failed_login_atmpts=0 WHERE (user_id = '" . $usr_id . "')";
    $result = executeSQLNoParams($sqlStr);
    if (loc_db_affected_rows($result) > 0) {
        if ($isAuto == 1) {
            echo "<strong>Automatic Password Successfully Generated!</strong><br/><br/>";
        } else {
            echo "<strong>Password Successfully Changed! <br/>"
            . "Click <a href=\"javascript: window.location='index.php';\">"
            . "here to return to HOME PAGE!</a></strong><br/><br/>";
        }
    }
}

function get_CurPlcy_SessnTime() {
    $sqlStr = "SELECT session_timeout FROM 
    sec.sec_security_policies WHERE is_default = 't'";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (int) $row[0];
    }
    return 300;
}

function get_CurPlcy_Mx_Dsply_Recs() {
    $sqlStr = "SELECT max_no_recs_to_dsply FROM 
    sec.sec_security_policies WHERE is_default = 't'";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (int) $row[0];
    }
    return 30;
}

function get_CurPlcy_Mx_Fld_lgns() {
    $sqlStr = "SELECT max_failed_lgn_attmpts FROM 
    sec.sec_security_policies WHERE is_default = 't'";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (int) $row[0];
    }
    return 1000000;
}

function get_CurPlcy_Pwd_Exp_Days() {
    $sqlStr = "SELECT pswd_expiry_days FROM 
    sec.sec_security_policies WHERE is_default = 't'";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (int) $row[0];
    }
    return 1000000;
}

function get_CurPlcy_Auto_Unlck_tme() {
    $sqlStr = "SELECT auto_unlocking_time_mins FROM 
       sec.sec_security_policies WHERE is_default = 't'";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (int) $row[0];
    }
    return 0;
}

function get_CurPlcy_DsllwdPswdCnt() {
    $sqlStr = "SELECT old_pswd_cnt_to_disallow FROM 
   sec.sec_security_policies WHERE is_default = 't'";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (int) $row[0];
    }
    return 10;
}

function get_CurPlcy_Min_Pwd_Len() {
    $sqlStr = "SELECT pswd_min_length FROM 
   sec.sec_security_policies WHERE is_default = 't'";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (int) $row[0];
    }
    return 1;
}

function get_CurPlcy_Mx_Pwd_Len() {
    $sqlStr = "SELECT pswd_max_length FROM 
   sec.sec_security_policies WHERE is_default = 't'";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (int) $row[0];
    }
    return 25;
}

function get_CrPlc_Rqrmt_Cmbntn() {
    $sqlStr = "SELECT pswd_reqrmnt_combntns FROM 
   sec.sec_security_policies WHERE is_default = 't'";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return "$row[0]";
    }
    return "NONE";
}

function doesPswdCmplxtyMeetPlcy($pswd
, $uname, &$msgStr) {
//Checks Whether a password meets the current password complexity policy
    $rqrmnts_met = 0;
    $minPwdLen = get_CurPlcy_Min_Pwd_Len();
    $maxPwdLen = get_CurPlcy_Mx_Pwd_Len();

    if (strlen($pswd) < $minPwdLen ||
            strlen($pswd) > $maxPwdLen) {
        $msgStr = "Length of Password must be between $minPwdLen and $maxPwdLen!";
        return false;
    }
    if (allowUnameInPswd() == false) {
        if (strpos(strtolower($pswd), strtolower($uname)) === true) {
            $msgStr = "Password must not contain user name!";
            return false;
        }
    }
    $allwRpeatng = allowRepeatngChars();
    $pwd_arry = str_split($pswd);
    $seenCaps = false;
    $seenSmall = false;
    $seenDigit = false;
    $seenWild = false;
    $msgStr = "";
    $isSmallReq = isSmallLtrRequired();
    $isCapsReq = isCapsRequired();
    $isDigitReq = isDigitRequired();
    $isWildReq = isWildCharRequired();
    $cmbntnSet = get_CrPlc_Rqrmt_Cmbntn();

    for ($i = 0; $i < count($pwd_arry); $i++) {
        if ($allwRpeatng === false && $i > 0) {
            if ($pwd_arry[$i] === $pwd_arry[$i - 1]) {
                $msgStr = "Password must not contain Repeating Characters!";
                return false;
            }
        }
        if (ctype_alpha($pwd_arry[$i])) {
            if (ctype_lower($pwd_arry[$i]) && $isSmallReq === true && $seenSmall === false) {
                $rqrmnts_met += 1;
                $seenSmall = true;
                continue;
            }
            if (ctype_upper($pwd_arry[$i]) && $isCapsReq === true && $seenCaps === false) {
                $rqrmnts_met += 1;
                $seenCaps = true;
                continue;
            }
        } else if (ctype_digit($pwd_arry[$i]) && $isDigitReq === true && $seenDigit === false) {
            $rqrmnts_met += 1;
            $seenDigit = true;
            continue;
        } else if (ctype_alnum($pwd_arry[$i]) === false && $isWildReq == true && $seenWild == false) {
            $rqrmnts_met += 1;
            $seenWild = true;
            continue;
        }
    }
    if ($cmbntnSet === "NONE" || $cmbntnSet === "") {
        return true;
    } else if ($cmbntnSet === "ALL 4" && $rqrmnts_met >= 4) {
        return true;
    } else if ($cmbntnSet === "ANY 3" && $rqrmnts_met >= 3) {
        return true;
    } else if ($cmbntnSet === "ANY 2" && $rqrmnts_met >= 2) {
        return true;
    } else if ($cmbntnSet === "ANY 1" && $rqrmnts_met >= 1) {
        return true;
    } else {
        $msgStr = "Password must contain " . $cmbntnSet . " of the ff:";
        if ($isCapsReq) {
            $msgStr .= "<br/>Block Letters!";
        }
        if ($isSmallReq) {
            $msgStr .= "<br/>Small Letters!";
        }
        if ($isDigitReq) {
            $msgStr .= "<br/>Numbers/Digits!";
        }
        if ($isWildReq) {
            $msgStr .= "<br/>Wild Characters (e.g. @, #)!";
        }
        return false;
    }
}

function isCapsRequired() {
//Checks Whether caps is required in a password


    $sqlStr = "SELECT pswd_require_caps FROM sec.sec_security_policies 
       WHERE is_default = 't' and pswd_require_caps='t'";
    $result = executeSQLNoParams($sqlStr);
    if (loc_db_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function isSmallLtrRequired() {
//Checks Whether small letter is required in a password
    $sqlStr = "SELECT pswd_require_small FROM sec.sec_security_policies 
       WHERE is_default = 't' and pswd_require_small='t'";


    $result = executeSQLNoParams($sqlStr);
    if (loc_db_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function isDigitRequired() {
//Checks Whether Digit is required in a password
    $sqlStr = "SELECT pswd_require_dgt FROM sec.sec_security_policies 
       WHERE is_default = 't' and pswd_require_dgt='t'";


    $result = executeSQLNoParams($sqlStr);
    if (loc_db_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function isWildCharRequired() {
//Checks Whether Wild Character is required in a password
    $sqlStr = "SELECT pswd_require_wild FROM sec.sec_security_policies 
       WHERE is_default = 't' and pswd_require_wild='t'";


    $result = executeSQLNoParams($sqlStr);
    if (loc_db_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function allowUnameInPswd() {
//Checks Whether User name is allowed in a password
    $sqlStr = "SELECT allow_usrname_in_pswds FROM sec.sec_security_policies 
       WHERE is_default = 't' and allow_usrname_in_pswds='t'";


    $result = executeSQLNoParams($sqlStr);
    if (loc_db_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function allowRepeatngChars() {
//Checks Whether Repeating Characters are allowed in a password
    $sqlStr = "SELECT allow_repeating_chars FROM sec.sec_security_policies 
       WHERE is_default = 't' and allow_repeating_chars='t'";


    $result = executeSQLNoParams($sqlStr);
    if (loc_db_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function doesPwdHvRptngChars($pwd) {
    for (
    $i = 0; $i < strlen($pwd); $i++) {
        if ($i > 0) {
            if (substr($pwd, $i, 1) === substr($pwd, ($i - 1), 1)) {
                return true;
            }
        }
    }
    return false;
}

function doesUsrIDHvThsRoleID($user_ID, $role_ID) {
    $sqlStr = "SELECT user_id FROM sec.sec_users_n_roles WHERE ((user_id = $user_ID) 
        AND (role_id = $role_ID))";
    $result = executeSQLNoParams($sqlStr);
    if (loc_db_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function doesUsrIDHvThsRoleIDNow($user_ID, $role_ID) {
    $sqlStr = "SELECT user_id FROM sec.sec_users_n_roles WHERE ((user_id = $user_ID) 
        AND (role_id = $role_ID) and (now() between to_timestamp(valid_start_date,'YYYY-MM-DD HH24:MI:SS') "
            . "and to_timestamp(valid_end_date,'YYYY-MM-DD HH24:MI:SS')))";
    $result = executeSQLNoParams($sqlStr);
    if (loc_db_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function selfAssignSSRoles($uID) {
    $userID = $_SESSION['USRID'];
    $start_date = date('d-M-Y H:i:s');
    $end_date = date('d-M-Y H:i:s', strtotime('31-Dec-4000 23:59:59'));
    $datestr = getDB_Date_time();
    $slctdRoles = "-1;" . getRoleID('Self-Service (Standard)') . ";" . $start_date . ";" . $end_date . "|";
    if ($slctdRoles != "") {
        $arry1 = explode('|', $slctdRoles);
        for ($i = 0; $i < count($arry1); $i++) {
            $arry2 = explode(';', $arry1[$i]);
            if ($arry2[0] == "") {
                continue;
            }
            $usrRoleID = $arry2[0];
            $roleID = $arry2[1];
            $usrHasRole = FALSE;

            if ($roleID > 0 && $uID > 0) {
                $usrHasRole = doesUsrIDHvThsRoleIDNow($uID, $roleID);
                $roleStrDte = cnvrtDMYTmToYMDTm($arry2[2]);
                $roleEndDate = cnvrtDMYTmToYMDTm($arry2[3]);
                if ($usrRoleID > 0) {
                    
                } else if ($usrHasRole == FALSE) {
                    $insSQL = "INSERT INTO sec.sec_users_n_roles(
            user_id, role_id, valid_start_date, valid_end_date, created_by, 
            creation_date, last_update_by, last_update_date)
    VALUES ($uID, $roleID, '$roleStrDte', '$roleEndDate', 
            $userID, '" . $datestr . "', $userID, '" . $datestr . "')";
                    execUpdtInsSQL($insSQL);
                }
            }
        }
    }
}

function registerThsModule($ModuleName, $ModuleDesc, $ModuleAdtTbl) {
    $dateStr = getDB_Date_time();
    $sqlStr = "INSERT INTO sec.sec_modules(module_name, module_desc, " .
            "date_added, audit_trail_tbl_name) VALUES ('" .
            loc_db_escape_string($ModuleName) . "', '" . loc_db_escape_string($ModuleDesc) .
            "', '" . $dateStr . "', '" . loc_db_escape_string($ModuleAdtTbl) . "')";
    $result = execUpdtInsSQL($sqlStr
    );
}

function registerThsModulesSubgroups($sub_grp_nm, $mn_table_nm, $rw_pk_nm, $mdlID) {
    $dateStr = getDB_Date_time();
    $sqlStr = "INSERT INTO sec.sec_module_sub_groups (sub_group_name, main_table_name, " .
            "row_pk_col_name, module_id, date_added) VALUES ('" .
            loc_db_escape_string($sub_grp_nm) . "', '" .
            loc_db_escape_string($mn_table_nm) . "', '" .
            loc_db_escape_string($rw_pk_nm) . "', " .
            $mdlID .
            ", '" . $dateStr . "')";
    $result = execUpdtInsSQL($sqlStr
    );
}

function createSampleRole($roleNm) {
    $uID = -1;
    global $usrID;
    if ($usrID <= 0) {
        $uID = getUserID("admin");
    } else {
        $uID = $usrID;
    }

    $dateStr = getDB_Date_time();
    $sqlStr = "INSERT INTO sec.sec_roles(role_name, valid_start_date, valid_end_date, created_by, " .
            "creation_date, last_update_by, last_update_date) VALUES ('" . loc_db_escape_string($roleNm) . "', '" .
            $dateStr . "', '4000-12-31 00:00:00', " . $uID . ", '" . $dateStr . "', " . $uID . ", '" . $dateStr . "')";
    $result = execUpdtInsSQL($sqlStr
    );
}

function createPrvldg($prvlg_nm, $ModuleName) {
    $sqlStr = "INSERT INTO sec.sec_prvldgs(prvldg_name, module_id) VALUES ('" .
            loc_db_escape_string($prvlg_nm) . "', " . getModuleID($ModuleName) . ")";
    $result = execUpdtInsSQL($sqlStr
    );
}

function asgnPrvlgToSmplRole($prvldg_id, $roleNm) {
    $uID = -1;
    global $usrID;
    if ($usrID <= 0) {
        $uID = getUserID("admin");
    } else {
        $uID = $usrID;
    }
    $dateStr = getDB_Date_time();
    if ($prvldg_id > 0) {
        $sqlStr = "INSERT INTO sec.sec_roles_n_prvldgs(role_id, prvldg_id, 
        valid_start_date, valid_end_date, created_by, " .
                "creation_date, last_update_by, last_update_date) VALUES (" .
                getRoleID($roleNm) . ", " . $prvldg_id . ", '" .
                $dateStr . "', '4000-12-31 00:00:00', " . $uID . ", '" .
                $dateStr . "', " . $uID . ", '" . $dateStr . "')";
        $result = execUpdtInsSQL($sqlStr
        );
    }
}

function hasRoleEvrHdThsPrvlg($inp_role_id, $inp_prvldg_id) {
    //Checks whether a given role 'system administrator' has a given priviledge
    $sqlStr = "SELECT role_id FROM sec.sec_roles_n_prvldgs WHERE ((prvldg_id = " .
            $inp_prvldg_id . ") AND (role_id = " . $inp_role_id .
            "))";
    $result = executeSQLNoParams($sqlStr);
    if (loc_db_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function getMdlGrpID($sub_grp_name, $ModuleName) {
    $sqlStr = "SELECT table_id from sec.sec_module_sub_groups where (sub_group_name = '" .
            loc_db_escape_string($sub_grp_name) . "' AND module_id = " .
            getModuleID($ModuleName) . ")";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function getMdlGrpTblID($sub_grp_name
, $mdlID) {
    $sqlStr = "SELECT table_id from sec.sec_module_sub_groups where (sub_group_name = '" .
            loc_db_escape_string($sub_grp_name) . "' AND module_id = " .
            $mdlID . ")";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return (float) $row[0];
    }
    return -1;
}

function checkNAssignReqrmnts($ModuleName
, $ModuleDesc, $ModuleAdtTbl, $SampleRole, $DefaultPrvldgs, $SubGrpNames, $MainTableNames, $KeyColumnNames) {
    if (getModuleID($ModuleName) == -1) {
        registerThsModule($ModuleName, $ModuleDesc, $ModuleAdtTbl);
    }

    $roleID = getRoleID($SampleRole);
    if ($roleID == -1) {
        createSampleRole($SampleRole);
        $roleID = getRoleID($SampleRole);
    }

    checkNCreatePrvldgs($DefaultPrvldgs, $ModuleName, $SampleRole);
    if ($SubGrpNames != null && $SubGrpNames != "") {
        checkNCreateSubGroups($ModuleName, $SubGrpNames, $MainTableNames, $KeyColumnNames);
    }
    $msg = "";
    $uID = getUserID("admin");
    if (doesUsrIDHvThsRoleID($uID, $roleID) == false) {
        asgnRoleToUser($uID, $roleID);
    }

    if ($ModuleName != "System Administration") {
        echo "<p style=\"font-size:12px;\">$msg Completed Module load for <b>$ModuleName ($SampleRole)!</b></p>";
    }
}

function asgnRoleToUser($uID, $roleID) {
    $dateStr = getDB_Date_time();
    $sqlStr = "INSERT INTO sec.sec_users_n_roles (user_id, role_id, valid_start_date, valid_end_date, created_by, 
creation_date, last_update_by, last_update_date) VALUES (" . $uID . ", " .
            $roleID . ", '" . $dateStr .
            "', '4000-12-31 00:00:00', " . $uID . ", '" . $dateStr . "', " . $uID . ", '" . $dateStr . "')";
    executeSQLNoParams($sqlStr);
}

function checkNCreatePrvldgs($brgtPrvldgs, $ModuleName, $roleNm) {
    for ($i = 0; $i < count($brgtPrvldgs); $i++) {
        if (getPrvldgID($brgtPrvldgs[$i], $ModuleName) == -1) {
            createPrvldg($brgtPrvldgs[$i], $ModuleName);
        }
        if (hasRoleEvrHdThsPrvlg(getRoleID($roleNm), getPrvldgID($brgtPrvldgs[$i], $ModuleName)) == false) {
            asgnPrvlgToSmplRole(getPrvldgID($brgtPrvldgs[$i], $ModuleName), $roleNm
            );
        }
    }
}

function checkNCreateSubGroups($ModuleName, $brgtGrps, $brgtTbls, $brgtKeyCols) {
    $mdlID = getModuleID($ModuleName);
    for ($i = 0; $i < count($brgtGrps); $i++) {
        if (getMdlGrpID($brgtGrps[$i], $ModuleName) == -1) {
            registerThsModulesSubgroups($brgtGrps[$i], $brgtTbls[$i], $brgtKeyCols[$i], $mdlID);
        } else {
            
        }
    }
}

function loadMdlsNthrRolesNLovs() {
    global $sysLovs;
    global $sysLovsDesc;
    global $sysLovsDynQrys;
    global $pssblVals;
    set_time_limit(300);
    loadSysAdminMdl();
    loadGenStpMdl();
    loadGenericMdl();
    loadOrgStpMdl();
    loadAccntngMdl();
    loadIntPymntsMdl();
    loadPersonMdl();
    loadRptMdl();
    loadHospMdl();
    loadWkflMdl();
    loadAlrtMdl();
    loadInvMdl();
    loadAcaMdl();
    loadAttnMdl();
    loadHotlMdl();
    loadMcfMdl();
    loadSelfMdl();
    //loadPSBMdl();
    loadProjsMdl();
    loadEvoteMdl();
    loadELibraryMdl();
    loadHelpDskMdl();
    createSysLovs($sysLovs, $sysLovsDesc, $sysLovsDynQrys);
    createSysLovsPssblVals($pssblVals, $sysLovs);

    $updtSQL = "UPDATE prs.prsn_names_nos 
        SET first_name='SYSTEM'
        WHERE local_id_no = 'RHO0002012'";
    executeSQLNoParams($updtSQL);

    echo "<p style=\"color:green;\">Click <a href=\"index.php\">here to RESTART Application!</a></p>";
}

function loadInvMdl() {
    $DefaultPrvldgs = array("View Inventory Manager",
        /* 1 */ "View Item List", "View Product Categories", "View Stores/Warehouses"
        /* 4 */, "View Receipts", "View Receipt Returns", "View Item Type Templates",
        /* 7 */ "View Item Balances",
        /* 8 */ "Add Items", "Update Items",
        /* 10 */ "Add Item Stores", "Update Item Stores", "Delete Item Stores",
        /* 13 */ "Add Product Category", "Update Product Category",
        /* 15 */ "Add Stores", "Update Stores",
        /* 17 */ "Add Store Users", "Update Store Users", "Delete Store Users",
        /* 20 */ "Add Store Shelves", "Delete Store Shelves",
        /* 22 */ "Add Receipt", "Delete Receipt",
        /* 24 */ "Add Receipt Return", "Delete Receipt Return",
        /* 26 */ "Add Item Template", "Update Item Template",
        /* 28 */ "Add Template Stores", "Update Template Stores",
        /* 30 */ "View GL Interface",
        /* 31 */ "View SQL", "View Record History", "Send To GL Interface Table",
        /* 34 */ "View Purchases", "View Sales/Item Issues", "View Sales Returns",
        /* 37 */ "View Payments Received",
        /* 38 */ "View Purchase Requisitions", "Add Purchase Requisitions", "Edit Purchase Requisitions", "Delete Purchase Requisitions",
        /* 42 */ "View Purchase Orders", "Add Purchase Orders", "Edit Purchase Orders", "Delete Purchase Orders",
        /* 46 */ "View Pro-Forma Invoices", "Add Pro-Forma Invoices", "Edit Pro-Forma Invoices", "Delete Pro-Forma Invoices",
        /* 50 */ "View Sales Orders", "Add Sales Orders", "Edit Sales Orders", "Delete Sales Orders",
        /* 54 */ "View Sales Invoices", "Add Sales Invoices", "Edit Sales Invoices", "Delete Sales Invoices",
        /* 58 */ "View Internal Item Requests", "Add Internal Item Requests", "Edit Internal Item Requests", "Delete Internal Item Requests",
        /* 62 */ "View Item Issues-Unbilled", "Add Item Issues-Unbilled", "Edit Item Issues-Unbilled", "Delete Item Issues-Unbilled",
        /* 66 */ "View Sales Returns", "Add Sales Return", "Edit Sales Return", "Delete Sales Return",
        /* 70 */ "Send GL Interface Records to GL", "Cancel Documents", "View only Self-Created Documents",
        /* 73 */ "View UOM", "Add UOM", "Edit UOM", "Delete UOM", "Make Payments", "Delete Product Category",
        /* 79 */ "View UOM Conversion", "Add UOM Conversion", "Edit UOM Conversion", "Delete UOM Conversion",
        /* 83 */ "View Drug Interactions", "Add Drug Interactions", "Edit Drug Interactions", "Delete Drug Interactions",
        /* 87 */ "Edit Receipt", "Edit Returns", "Edit Store Transfers", "Edit Adjustments",
        /* 91 */ "Clear Stock Balance", "Do Quick Receipt",
        /* 93 */ "View Item Production", "Add Item Production", "Edit Item Production", "Delete Item Production",
        /* 97 */ "Setup Production Processes", "Apply Adhoc Discounts",
        /* 99 */ "View Production Runs", "Add Production Runs", "Edit Production Runs", "Delete Production Runs",
        /* 103 */ "Can Edit Unit Price");

    $subGrpNames = "";
    $mainTableNames = "";
    $keyColumnNames = "";
    $myName = "Stores And Inventory Manager";
    $myDesc = "This module helps you to manage your organization's Inventory System!";
    $audit_tbl_name = "inv.inv_audit_trail_tbl";
    $smplRoleName = "Stores And Inventory Manager Administrator";

    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
}

function loadWkflMdl() {
    //For Workfl0w
    $DefaultPrvldgs = array("View Workflow Manager", "View Workflow Apps",
        /* 2 */ "View Workflow Hierarchies", "View Approver Groups",
        /* 4 */ "View Workflow Notifications", "View Record History", "View SQL",
        /* 7 */ "Add Workflow Apps", "Edit Workflow Apps", "Delete Workflow Apps",
        /* 10 */ "Add Workflow Hierarchies", "Edit Workflow Hierarchies", "Delete Workflow Hierarchies",
        /* 13 */ "Add Approver Groups", "Edit Approver Groups", "Delete Approver Groups",
        /* 16 */ "Administer Notifications", "Administer Workflow Setups");


    $subGrpNames = "";
    $mainTableNames = "";
    $keyColumnNames = "";
    $myName = "Workflow Manager";
    $myDesc = "This module helps you to configure the application's workflow system!";
    $audit_tbl_name = "wkf.wkf_audit_trail_tbl";
    $smplRoleName = "Workflow Manager Administrator";


    createWkfRqrdLOVs();
    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
}

function createWkfRqrdLOVs() {

    $sysLovs = array("Hierarchy Names", "Workflow Apps", "Approver Groups");
    $sysLovsDesc = array("Hierarchy Names", "Workflow Apps", "Approver Groups");
    $sysLovsDynQrys = array("select distinct trim(to_char(hierarchy_id,'999999999999999999999999999999')) a, hierarchy_name b, '' c from wkf.wkf_hierarchy_hdr order by hierarchy_name",
        "select distinct trim(to_char(app_id,'999999999999999999999999999999')) a, app_name b, '' c from wkf.wkf_apps order by app_name",
        "select distinct ''||apprvr_group_id a, group_name b, '' c from wkf.wkf_apprvr_groups order by group_name");
    //$pssblVals = array("","","");

    createSysLovs($sysLovs, $sysLovsDesc, $sysLovsDynQrys);
    //createSysLovsPssblVals($pssblVals, $sysLovs);
    //
    //Workflow Message Types
    //1. Informational
    //2. Approval Document
    //3. Information Request
    //4. Working Document
    //5. Login App
    $appID = getAppID('Login', 'System Administration');
    //$prgmID = getGnrlRecID2("rpt.rpt_prcss_rnnrs", "rnnr_name", "prcss_rnnr_id", "REQUESTS LISTENER PROGRAM");
    if ($appID <= 0) {
        createWkfApp('Login', 'System Administration', 'Login Welcome Messages');
        $appID = getAppID('Login', 'System Administration');
    } else {
        updateWkfApp($appID, 'Login', 'System Administration', 'Login Welcome Messages');
    }

    $actionNm = array("Acknowledge"); //, "Test Open", "Test Reject", "Test Re-assign", "Test Request for Information", "Test Close", "Test Respond"
    $desc = array("User acknowledges receipt of the Message"); //, "Test Action", "Test Action", "Test Action", "Test Action", "Test Action", "Test Action"
    $sqlStmnt = array("select wkf.action_sql_for_login({:routing_id},{:userID},'{:actToPrfm}');"); //, "", "", "", "", "", ""
    $exctbl = array(""); //, "", "", "", "", "", ""
    $webURL = array("grp=1&typ=10&q=act&RoutingID={:wkfRtngID}&actyp={:wkfAction}");
    $isdiag = array("1"); //, "0", "1", "1", "1", "1", "1"
    $isadmnonly = array("0");

    for ($i = 0; $i < count($actionNm); $i++) {
        $appActionID = getGnrlRecIDExtr("wkf.wkf_apps_actions", "action_performed_nm", "app_id", "action_sql_id", $actionNm[$i], $appID);
        if ($appActionID <= 0) {
            createWkfAppAction($actionNm[$i], $sqlStmnt[$i], $appID, $exctbl[$i], $webURL[$i], $isdiag[$i], $desc[$i], $isadmnonly[$i]);
        } else {
            updateWkfAppAction($appActionID, $actionNm[$i], $sqlStmnt[$i], $appID, $exctbl[$i], $webURL[$i], $isdiag[$i], $desc[$i], $isadmnonly[$i]);
        }
    }

    //Clinic App
    $appID = getAppID('Clinical Appointments', 'Clinic/Hospital');
    //$prgmID = getGnrlRecID2("rpt.rpt_prcss_rnnrs", "rnnr_name", "prcss_rnnr_id", "REQUESTS LISTENER PROGRAM");
    if ($appID <= 0) {
        createWkfApp('Clinical Appointments', 'Clinic/Hospital', 'Messages related to Clinic/Hospital Appointments');
        $appID = getAppID('Clinical Appointments', 'Clinic/Hospital');
    } else {
        updateWkfApp($appID, 'Clinical Appointments', 'Clinic/Hospital', 'Messages related to Clinic/Hospital Appointments');
    }

    $actionNm = array("Open", "Reject", "Request for Information", "Close", "Respond", "Acknowledge");
    $desc = array("User can Open the Working Document to work on it",
        "User can Reject i.e. Refuse to work on the Document Assigning a Reason",
        "User can Request for additional Information on the Document before working on it",
        "User can close a working document to indicate all work on it has been done!",
        "User can Respond to an Information Request Message",
        "User acknowledges receipt of the Message");
    $sqlStmnt = array("", "", "", "", "", "");
    $exctbl = array("", "", "", "", "", "");
    $webURL = array("index1.php?ajx=1&grp=14&typ=1&pg=2&q=Clinic/Hospital&vwtyp=0&actyp=0&wkfRtngID={:wkfRtngID}",
        "ajx=1&grp=14&typ=1&pg=2&q=Clinic/Hospital&vwtyp=115&actyp=0&slctdRtngID={:wkfRtngID}",
        "ajx=1&grp=14&typ=1&pg=2&q=Clinic/Hospital&vwtyp=117&actyp=0&slctdRtngID={:wkfRtngID}",
        "index.php",
        "index.php",
        "index.php");
    $isdiag = array("0", "1", "1", "1", "1", "1");
    $isadmnonly = array("0", "0", "0", "0", "0", "0", "0");
    for ($i = 0; $i < count($actionNm); $i++) {
        $appActionID = getGnrlRecIDExtr("wkf.wkf_apps_actions", "action_performed_nm", "app_id", "action_sql_id", $actionNm[$i], $appID);
        if ($appActionID <= 0) {
            createWkfAppAction($actionNm[$i], $sqlStmnt[$i], $appID, $exctbl[$i], $webURL[$i], $isdiag[$i], $desc[$i], $isadmnonly[$i]);
        } else {
            updateWkfAppAction($appActionID, $actionNm[$i], $sqlStmnt[$i], $appID, $exctbl[$i], $webURL[$i], $isdiag[$i], $desc[$i], $isadmnonly[$i]);
        }
    }

    //Personal Records Change
    $appID = getAppID('Personal Records Change', 'Basic Person Data');
    //$prgmID = getGnrlRecID2("rpt.rpt_prcss_rnnrs", "rnnr_name", "prcss_rnnr_id", "REQUESTS LISTENER PROGRAM");
    if ($appID <= 0) {
        createWkfApp('Personal Records Change', 'Basic Person Data', 'Messages related to Basic Person Data Change Requests');
        $appID = getAppID('Personal Records Change', 'Basic Person Data');
    } else {
        updateWkfApp($appID, 'Personal Records Change', 'Basic Person Data', 'Messages related to Basic Person Data Change Requests');
    }

    $actionNm = array("Open", "Reject", "Request for Information", "Respond", "Acknowledge", "Approve");
    $desc = array(
        "User can Open the Working Document to work on it",
        "User can Reject i.e. Refuse to work on the Document Assigning a Reason",
        "User can Request for additional Information on the Document before working on it",
        "User can Respond to an Information Request Message",
        "User acknowledges receipt of the Message",
        "User approves submitted request");
    $sqlStmnt = array("", "", "", "", "", "");
    $exctbl = array("", "", "", "", "", "");
    $webURL = array("grp=8&typ=1&pg=2&q=UPDATE&actyp=40&RoutingID={:wkfRtngID}&actiontyp={:wkfAction}",
        "grp=8&typ=1&pg=2&q=UPDATE&actyp=40&RoutingID={:wkfRtngID}&actiontyp={:wkfAction}&actReason={:wkfActReason}&toPrsLocID={:wkfToPrsLocID}",
        "grp=8&typ=1&pg=2&q=UPDATE&actyp=40&RoutingID={:wkfRtngID}&actiontyp={:wkfAction}&actReason={:wkfActReason}&toPrsLocID={:wkfToPrsLocID}",
        "grp=8&typ=1&pg=2&q=UPDATE&actyp=40&RoutingID={:wkfRtngID}&actiontyp={:wkfAction}&actReason={:wkfActReason}&toPrsLocID={:wkfToPrsLocID}",
        "grp=8&typ=1&pg=2&q=UPDATE&actyp=40&RoutingID={:wkfRtngID}&actiontyp={:wkfAction}",
        "grp=8&typ=1&pg=2&q=UPDATE&actyp=40&RoutingID={:wkfRtngID}&actiontyp={:wkfAction}");
    $isdiag = array("0", "1", "1", "1", "1", "1");
    $isadmnonly = array("0", "0", "0", "0", "0", "0");
    for ($i = 0; $i < count($actionNm); $i++) {
        $appActionID = getGnrlRecIDExtr("wkf.wkf_apps_actions", "action_performed_nm", "app_id", "action_sql_id", $actionNm[$i], $appID);
        if ($appActionID <= 0) {
            createWkfAppAction($actionNm[$i], $sqlStmnt[$i], $appID, $exctbl[$i], $webURL[$i], $isdiag[$i], $desc[$i], $isadmnonly[$i]);
        } else {
            updateWkfAppAction($appActionID, $actionNm[$i], $sqlStmnt[$i], $appID, $exctbl[$i], $webURL[$i], $isdiag[$i], $desc[$i], $isadmnonly[$i]);
        }
    }

    //Payment System Banking
    $appID = getAppID('PSB Forms Submission', 'Payment Systems Banking');
    //$prgmID = getGnrlRecID2("rpt.rpt_prcss_rnnrs", "rnnr_name", "prcss_rnnr_id", "REQUESTS LISTENER PROGRAM");
    if ($appID <= 0) {
        createWkfApp('PSB Forms Submission', 'Payment Systems Banking', 'Messages related to PSB Forms Submitted');
        $appID = getAppID('PSB Forms Submission', 'Payment Systems Banking');
    } else {
        updateWkfApp($appID, 'PSB Forms Submission', 'Payment Systems Banking', 'Messages related to PSB Forms Submitted');
    }

    $actionNm = array("Open", "Reject", "Request for Information", "Respond", "Acknowledge", "Approve");
    $desc = array(
        "User can Open the Working Document to work on it",
        "User can Reject i.e. Refuse to work on the Document Assigning a Reason",
        "User can Request for additional Information on the Document before working on it",
        "User can Respond to an Information Request Message",
        "User acknowledges receipt of the Message",
        "User approves submitted request");
    $sqlStmnt = array("", "", "", "", "", "");
    $exctbl = array("", "", "", "", "", "");
    $webURL = array("grp=20&typ=1&q=SUBMIT&RoutingID={:wkfRtngID}&actyp={:wkfAction}",
        "grp=20&typ=1&q=SUBMIT&RoutingID={:wkfRtngID}&actyp={:wkfAction}&actReason={:wkfActReason}&toPrsLocID={:wkfToPrsLocID}",
        "grp=20&typ=1&q=SUBMIT&RoutingID={:wkfRtngID}&actyp={:wkfAction}&actReason={:wkfActReason}&toPrsLocID={:wkfToPrsLocID}",
        "grp=20&typ=1&q=SUBMIT&RoutingID={:wkfRtngID}&actyp={:wkfAction}&actReason={:wkfActReason}&toPrsLocID={:wkfToPrsLocID}",
        "grp=20&typ=1&q=SUBMIT&RoutingID={:wkfRtngID}&actyp={:wkfAction}",
        "grp=20&typ=1&q=SUBMIT&RoutingID={:wkfRtngID}&actyp={:wkfAction}");
    $isdiag = array("0", "1", "1", "1", "1", "1");
    $isadmnonly = array("0", "0", "0", "0", "0", "0");
    for ($i = 0; $i < count($actionNm); $i++) {
        $appActionID = getGnrlRecIDExtr("wkf.wkf_apps_actions", "action_performed_nm", "app_id", "action_sql_id", $actionNm[$i], $appID);
        if ($appActionID <= 0) {
            createWkfAppAction($actionNm[$i], $sqlStmnt[$i], $appID, $exctbl[$i], $webURL[$i], $isdiag[$i], $desc[$i], $isadmnonly[$i]);
        } else {
            updateWkfAppAction($appActionID, $actionNm[$i], $sqlStmnt[$i], $appID, $exctbl[$i], $webURL[$i], $isdiag[$i], $desc[$i], $isadmnonly[$i]);
        }
    }
}

function loadAlrtMdl() {
    //For Accounting
    $DefaultPrvldgs = array("View Alerts Manager", "View Alert Messages Sent",
        "View Record History", "View SQL");

    $subGrpNames = ""; //, "Accounting Transactions"
    $mainTableNames = ""; //, "accb.accb_trnsctn_details"
    $keyColumnNames = ""; //, "transctn_id" 
    $myName = "Alerts Manager";
    $myDesc = "This module helps you to configure the application's Alert System!";
    $audit_tbl_name = "alrt.alrt_audit_trail_tbl";
    $smplRoleName = "Alerts Manager Administrator";

    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
}

function loadHelpDskMdl() {
    //For Accounting
    $DefaultPrvldgs = array("View Help Desk",
        /* 1 */ "View Help Desk Dashboard",
        /* 2 */ "View My Request Tickets", "View All Request Tickets",
        /* 4 */ "View SQL", "View Record History",
        /* 6 */ "Add Request Tickets", "Edit Request Tickets", "Delete Request Tickets",
        /* 9 */ "Add Tickets for Others", "Edit Tickets for Others", "Delete Tickets for Others");

    $subGrpNames = "";
    $mainTableNames = "";
    $keyColumnNames = "";
    $myName = "Service Desk Manager";
    $myDesc = "This module helps you to manage your support tickets and I.T Service requests!";
    $audit_tbl_name = "hlpd.hlpd_audit_trail_tbl";
    $smplRoleName = "Service Desk Manager Administrator";

    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
}

function loadSysAdminMdl() {
    //For Accounting
    global $sysLovs, $sysLovsDesc, $sysLovsDynQrys;

    $DefaultPrvldgs = array("View System Administration", "View Users & their Roles",
        /* 2 */ "View Roles & their Priviledges", "View Registered Modules & their Priviledges",
        /* 4 */ "View Security Policies", "View Server Settings", "View User Logins",
        /* 7 */ "View Audit Trail Tables", "Add New Users & their Roles", "Edit Users & their Roles",
        /* 10 */ "Add New Roles & their Priviledges", "Edit Roles & their Priviledges",
        /* 12 */ "Add New Security Policies", "Edit Security Policies", "Add New Server Settings",
        /* 15 */ "Edit Server Settings", "Set manual password for users",
        /* 17 */ "Send System Generated Passwords to User Mails",
        /* 18 */ "View SQL", "View Record History", "Add/Edit Extra Info Labels", "Delete Extra Info Labels",
        /* 22 */ "Add Notices", "Edit Notices", "Delete Notices", "View Notices Admin");

    $subGrpNames = ""; //, "Accounting Transactions"
    $mainTableNames = ""; //, "accb.accb_trnsctn_details"
    $keyColumnNames = ""; //, "transctn_id" 
    $myName = "System Administration";
    $myDesc = "This module helps you to administer all the security features of this software!";
    $audit_tbl_name = "sec.sec_audit_trail_tbl";
    $smplRoleName = "System Administrator";

    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
    createSysLovs($sysLovs, $sysLovsDesc, $sysLovsDynQrys);

    $sysLovs2 = array("Notice Classifications");
    $sysLovsDesc2 = array("Notice Classifications");
    $sysLovsDynQrys2 = array("");
    $pssblVals2 = array("0", "System Notifications", "System Notifications");
    createSysLovs($sysLovs2, $sysLovsDesc2, $sysLovsDynQrys2);
    createSysLovsPssblVals($pssblVals2, $sysLovs2);
}

function loadAccntngMdl() {
    //For Accounting
    $DefaultPrvldgs = array("View Accounting", "View Chart of Accounts",
        /* 2 */ "View Account Transactions", "View Transactions Search",
        /* 4 */ "View/Generate Trial Balance", "View/Generate Profit & Loss Statement",
        /* 6 */ "View/Generate Balance Sheet", "View Budgets",
        /* 8 */ "View Transaction Templates", "View Record History", "View SQL",
        /* 11 */ "Add Chart of Accounts", "Edit Chart of Accounts", "Delete Chart of Accounts",
        /* 14 */ "Add Batch for Transactions", "Edit Batch for Transactions", "Void/Delete Batch for Transactions",
        /* 17 */ "Add Transactions Directly", "Edit Transactions", "Delete Transactions",
        /* 20 */ "Add Transactions Using Template", "Post Transactions",
        /* 22 */ "Add Budgets", "Edit Budgets", "Delete Budgets",
        /* 25 */ "Add Transaction Templates", "Edit Transaction Templates", "Delete Transaction Templates",
        /* 28 */ "View Only Self-Created Transaction Batches",
        /* 29 */ "View Financial Statements", "View Accounting Periods", "View Payables",
        /* 32 */ "View Receivables", "View Customers/Suppliers", "View Tax Codes",
        /* 35 */ "View Default Accounts", "View Account Reconciliation",
        /* 37 */ "Add Accounting Periods", "Edit Accounting Periods", "Delete Accounting Periods",
        /* 40 */ "View Fixed Assets", "View Payments",
        /* 42 */ "Add Payment Methods", "Edit Payment Methods", "Delete Payment Methods",
        /* 45 */ "Add Supplier Standard Payments", "Edit Supplier Standard Payments", "Delete Supplier Standard Payments",
        /* 48 */ "Add Supplier Advance Payments", "Edit Supplier Advance Payments", "Delete Supplier Advance Payments",
        /* 51 */ "Setup Exchange Rates", "Setup Document Templates", "Review/Approve Payables Documents", "Review/Approve Receivables Documents",
        /* 55 */ "Add Direct Refund from Supplier", "Edit Direct Refund from Supplier", "Delete Direct Refund from Supplier",
        /* 58 */ "Add Supplier Credit Memo (InDirect Refund)", "Edit Supplier Credit Memo (InDirect Refund)", "Delete Supplier Credit Memo (InDirect Refund)",
        /* 61 */ "Add Direct Topup for Supplier", "Edit Direct Topup for Supplier", "Delete Direct Topup for Supplier",
        /* 64 */ "Add Supplier Debit Memo (InDirect Topup)", "Edit Supplier Debit Memo (InDirect Topup)", "Delete Supplier Debit Memo (InDirect Topup)",
        /* 67 */ "Cancel Payables Documents", "Cancel Receivables Documents",
        /* 69 */ "Reject Payables Documents", "Reject Receivables Documents",
        /* 71 */ "Pay Payables Documents", "Pay Receivables Documents",
        /* 73 */ "Add Customer Standard Payments", "Edit Customer Standard Payments", "Delete Customer Standard Payments",
        /* 76 */ "Add Customer Advance Payments", "Edit Customer Advance Payments", "Delete Customer Advance Payments",
        /* 79 */ "Add Direct Refund to Customer", "Edit Direct Refund to Customer", "Delete Direct Refund to Customer",
        /* 82 */ "Add Customer Credit Memo (InDirect Topup)", "Edit Customer Credit Memo (InDirect Topup)", "Delete Customer Credit Memo (InDirect Topup)",
        /* 85 */ "Add Direct Topup from Customer", "Edit Direct Topup from Customer", "Delete Direct Topup from Customer",
        /* 88 */ "Add Customer Debit Memo (InDirect Refund)", "Edit Customer Debit Memo (InDirect Refund)", "Delete Customer Debit Memo (InDirect Refund)",
        /* 91 */ "Add Customers/Suppliers", "Edit Customers/Suppliers", "Delete Customers/Suppliers",
        /* 94 */ "Add Fixed Assets", "Edit Fixed Assets", "Delete Fixed Assets"
        /* 97 */, "View Petty Cash Vouchers", "View Petty Cash Payments", "Add Petty Cash Payments", "Edit Petty Cash Payments", "Delete Petty Cash Payments"
        /* 102 */, "View Petty Cash Re-imbursements", "Add Petty Cash Re-imbursements", "Edit Petty Cash Re-imbursements", "Delete Petty Cash Re-imbursements");

    $subGrpNames = array("Chart of Accounts"); //, "Accounting Transactions"
    $mainTableNames = array("accb.accb_chart_of_accnts"); //, "accb.accb_trnsctn_details"
    $keyColumnNames = array("accnt_id"); //, "transctn_id" 
    $myName = "Accounting/Finance";
    $myDesc = "This module helps you to manage your organization's Accounting!";
    $audit_tbl_name = "accb.accb_audit_trail_tbl";
    $smplRoleName = "Accounting/Finance Administrator";

    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
}

function loadPersonMdl() {
    //For Accounting
    $DefaultPrvldgs = array("View Person", "View Basic Person Data",
        /* 2 */ "View Curriculum Vitae", "View Basic Person Assignments",
        /* 4 */ "View Person Pay Item Assignments", "View SQL", "View Record History",
        /* 7 */ "Add Person Info", "Edit Person Info", "Delete Person Info",
        /* 10 */ "Add Basic Assignments", "Edit Basic Assignments", "Delete Basic Assignments",
        /* 13 */ "Add Pay Item Assignments", "Edit Pay Item Assignments", "Delete Pay Item Assignments", "View Banks",
        /* 17 */ "Define Assignment Templates", "Edit Assignment Templates", "Delete Assignment Templates",
        /* 20 */ "View Assignment Templates", "Manage My Firm");

    $subGrpNames = array("Person Data");
    $mainTableNames = array("prs.prsn_names_nos");
    $keyColumnNames = array("person_id");
    $myName = "Basic Person Data";
    $myDesc = "This module helps you to setup basic information " +
            "about people in your organization!";
    $audit_tbl_name = "prs.prsn_audit_trail_tbl";
    $smplRoleName = "Basic Person Data Administrator";

    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
}

function loadGenStpMdl() {
    $DefaultPrvldgs = array("View General Setup", "View Value List Names"
        , "View possible values", /* 3 */ "Add Value List Names", "Edit Value List Names"
        , "Delete Value List Names", /* 6 */ "Add Possible Values", "Edit Possible Values"
        , "Delete Possible Values", "View Record History", "View SQL");

    $subGrpNames = "";
    $mainTableNames = "";
    $keyColumnNames = "";
    $myName = "General Setup";
    $myDesc = "This module helps you to setup basic information " +
            "to be used by the software later!";
    $audit_tbl_name = "gst.gen_stp_audit_trail_tbl";

    $smplRoleName = "General Setup Administrator";

    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
}

function loadProjsMdl() {
    $DefaultPrvldgs = array(
        "View Projects Management",
        /* 1 */ "View Projects", "View Accounts Setup",
        /* 3 */ "View Resources Setup", "View SQL", "View Record History",
        /* 6 */ "Add Projects", "Edit Projects", "Delete Projects",
        /* 9 */ "Add Accounts", "Edit Accounts", "Delete Accounts",
        /* 12 */ "Add Resource", "Edit Resource", "Delete Resource",
        /* 15 */ "View Project Costs", "Edit Project Costs");

    $subGrpNames = "";
    $mainTableNames = "";
    $keyColumnNames = "";
    $myName = "Projects Management";
    $myDesc = "This module helps you to manage your organization's Projects and their Associated Costs!";
    $audit_tbl_name = "proj.proj_audit_trail_tbl";

    $smplRoleName = "Projects Management Administrator";

    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
}

function loadGenericMdl() {
    $DefaultPrvldgs = array("View Generic Module");

    $subGrpNames = "";
    $mainTableNames = "";
    $keyColumnNames = "";
    $myName = "Generic Module";
    $myDesc = "This module is a mere place holder for categorising reports and processes!";
    $audit_tbl_name = "sec.sec_audit_trail_tbl";

    $smplRoleName = "Generic Module Administrator";

    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
}

function loadIntPymntsMdl() {
    $DefaultPrvldgs = array("View Internal Payments",
        /* 1 */ "View Manual Payments", "View Pay Item Sets", "View Person Sets",
        /* 4 */ "View Mass Pay Runs", "View Payment Transactions", "View GL Interface Table",
        /* 7 */ "View Record History", "View SQL",
        /* 9 */ "Add Manual Payments", "Reverse Manual Payments",
        /* 11 */ "Add Pay Item Sets", "Edit Pay Item Sets", "Delete Pay Item Sets",
        /* 14 */ "Add Person Sets", "Edit Person Sets", "Delete Person Sets",
        /* 17 */ "Add Mass Pay", "Edit Mass Pay", "Delete Mass Pay",
        "Send Mass Pay Transactions to Actual GL",
        /* 21 */ "Send All Transactions to Actual GL", "Run Mass Pay",
        "Rollback Mass Pay Run", "Send Selected Transactions to Actual GL");

    $subGrpNames = "";
    $mainTableNames = "";
    $keyColumnNames = "";
    $myName = "Internal Payments";
    $myDesc = "This module helps you to manage your organization's HR Payments to Personnel!";
    $audit_tbl_name = "pay.pay_audit_trail_tbl";

    $smplRoleName = "Internal Payments Administrator";

    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
}

function loadPSBMdl() {
    //For Accounting
    //global $sysLovs, $sysLovsDesc, $sysLovsDynQrys;
    $DefaultPrvldgs = array("View PSB",
        /* 1 */ "View PSB Periods", "Add PSB Periods", "Edit PSB Periods", "Save PSB Periods", "Delete PSB Periods",
        /* 6 */ "Open PSB Periods", "Close PSB Periods",
        /* 8 */ "View PSB1", "View PSB2", "View PSB3", "View PSB4", "View PSB5", "View PSB6",
        /* 14 */ "View PSB7", "View PSB8A", "View PSB8B", "View PSB8C", "View PSB9", "View PSB10",
        /* 20 */ "Add PSB1", "Add PSB2", "Add PSB3", "Add PSB4", "Add PSB5", "Add PSB6",
        /* 26 */ "Add PSB7", "Add PSB8A", "Add PSB8B", "Add PSB8C", "Add PSB9", "Add PSB10",
        /* 32 */ "Edit PSB1", "Edit PSB2", "Edit PSB3", "Edit PSB4", "Edit PSB5", "Edit PSB6",
        /* 38 */ "Edit PSB7", "Edit PSB8A", "Edit PSB8B", "Edit PSB8C", "Edit PSB9", "Edit PSB10",
        /* 44 */ "Delete PSB1", "Delete PSB2", "Delete PSB3", "Delete PSB4", "Delete PSB5", "Delete PSB6",
        /* 50 */ "Delete PSB7", "Delete PSB8A", "Delete PSB8B", "Delete PSB8C", "Delete PSB9", "Delete PSB10",
        /* 56 */ "Submit PSB1", "Submit PSB2", "Submit PSB3", "Submit PSB4", "Submit PSB5", "Submit PSB6",
        /* 62 */ "Submit PSB7", "Submit PSB8A", "Submit PSB8B", "Submit PSB8C", "Submit PSB9", "Submit PSB10",
        /* 67 */ "View PSB2 Summary", "View PSB4 P/I Involved", "View PSB7 P/I Involved",
        /* 70 */ "Upload PSB8A CSV", "Upload PSB8B CSV", "Upload PSB8C CSV",
        /* 73 */ "PSB1 Superuser", "PSB2 Superuser", "PSB3 Superuser", "PSB4 Superuser", "PSB5 Superuser", "PSB6 Superuser",
        /* 79 */ "PSB7 Superuser", "PSB8A Superuser", "PSB8B Superuser", "PSB8C Superuser", "PSB9 Superuser", "PSB10 Superuser",
        /* 85 */ "Download PSB8A CSV", "Download PSB8B CSV", "Download PSB8C CSV",
        /* 88 */ "View SQL", "View Record History");

    $subGrpNames = ""; //, "Accounting Transactions"
    $mainTableNames = ""; //, "accb.accb_trnsctn_details"
    $keyColumnNames = ""; //, "transctn_id" 
    $myName = "Payment Systems Banking";
    $myDesc = "This module helps you to manage the payment systems banking returns!";
    $audit_tbl_name = "sec.sec_audit_trail_tbl";
    $smplRoleName = "PSB Administrator";

    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
    //createSysLovs($sysLovs, $sysLovsDesc, $sysLovsDynQrys);
}

function loadOrgStpMdl() {
    $DefaultPrvldgs = array("View Organisation Setup",
        "View Org Details", "View Divisions/Groups", "View Sites/Locations",
        /* 4 */ "View Jobs", "View Grades", "View Positions", "View Benefits",
        /* 8 */ "View Pay Items", "View Remunerations", "View Working Hours",
        /* 11 */ "View Gathering Types", "View SQL", "View Record History",
        /* 14 */ "Add Org Details", "Edit Org Details",
        /* 16 */ "Add Divisions/Groups", "Edit Divisions/Groups", "Delete Divisions/Groups",
        /* 19 */ "Add Sites/Locations", "Edit Sites/Locations", "Delete Sites/Locations",
        /* 22 */ "Add Jobs", "Edit Jobs", "Delete Jobs",
        /* 25 */ "Add Grades", "Edit Grades", "Delete Grades",
        /* 28 */ "Add Positions", "Edit Positions", "Delete Positions");
    $subGrpNames = array("Organisation's Details", "Divisions/Groups",
        "Sites/Locations", "Jobs", "Grades", "Positions");
    $mainTableNames = array("org.org_details", "org.org_divs_groups",
        "org.org_sites_locations", "org.org_jobs", "org.org_grades", "org.org_positions");
    $keyColumnNames = array("org_id", "div_id",
        "location_id", "job_id", "grade_id", "position_id");
    $myName = "Organisation Setup";
    $myDesc = "This module helps you to setup basic information " +
            "about your organisation!";
    $audit_tbl_name = "org.org_audit_trail_tbl";

    $smplRoleName = "Organisation Setup Administrator";

    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
}

function loadRptMdl() {
    $DefaultPrvldgs = array("View Reports And Processes",
        /* 1 */ "View Report Definitions", "View Report Runs", "View SQL", "View Record History",
        /* 5 */ "Add Report/Process", "Edit Report/Process", "Delete Report/Process",
        /* 8 */ "Run Reports/Process", "Delete Report/Process Runs", "View Runs from Others",
        /* 11 */ "Delete Run Output File", "Add Alert", "Edit Alert", "Delete Alert");

    $subGrpNames = "";
    $mainTableNames = "";
    $keyColumnNames = "";

    $myName = "Reports And Processes";
    $myDesc = "This module helps you to manage all reports in the software!";
    $audit_tbl_name = "rpt.rpt_audit_trail_tbl";

    $smplRoleName = "Reports And Processes Administrator";

    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
}

function loadEvoteMdl() {
    $DefaultPrvldgs = array("View e-Voting",
        /* 1 */ "View All Surveys/Elections", "View Questions Bank", "View Person Sets",
        /* 4 */ "View Record History", "View SQL",
        /* 6 */ "Add Surveys/Elections", "Edit Surveys/Elections", "Delete Surveys/Elections",
        /* 9 */ "Add Questions Bank", "Edit Questions Bank", "Delete Questions Bank");

    $subGrpNames = "";
    $mainTableNames = "";
    $keyColumnNames = "";

    $myName = "e-Voting";
    $myDesc = "This is where Elections/Polls/Surveys in the Organisation are Conducted and Managed!";
    $audit_tbl_name = "self.self_prsn_audit_trail_tbl";

    $smplRoleName = "e-Voting Administrator";

    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);

    $sysLovs = array("Questions Bank", "Question Possible Answers");
    $sysLovsDesc = array("Questions Bank", "Question Possible Answers");
    $sysLovsDynQrys = array("select '' || qstn_id a, qstn_desc b, '' c "
        . "from self.self_question_bank order by qstn_id",
        "select '' || psbl_ansr_id a, psbl_ansr_desc b, '' c, qstn_id d, '' || qstn_id e "
        . "from self.self_question_possible_answers where is_enabled='1' order by psbl_ansr_order_no");

    createSysLovs($sysLovs, $sysLovsDesc, $sysLovsDynQrys);
}

function loadELibraryMdl() {
    $DefaultPrvldgs = array("View e-Library",
        /* 1 */ "View All Exams/Tests", "View Questions Bank", "View Person Sets",
        /* 4 */ "View Record History", "View SQL",
        /* 6 */ "Add Exams/Tests", "Edit Exams/Tests", "Delete Exams/Tests",
        /* 9 */ "Add Questions Bank", "Edit Questions Bank", "Delete Questions Bank");

    $subGrpNames = "";
    $mainTableNames = "";
    $keyColumnNames = "";

    $myName = "e-Library";
    $myDesc = "This is where Examinations/Tests in the Institution are Conducted and Managed!";
    $audit_tbl_name = "self.self_prsn_audit_trail_tbl";

    $smplRoleName = "e-Library Administrator";

    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
}

function loadHospMdl() {
    $DefaultPrvldgs = array(/* 0 */ "View Visits and Appointments",
        /* 1 */ "View Visits/Appointments", "View Appointments Data", "View Service Providers", "View Services Offered",
        /* 5 */ "View SQL", "View Record History",
        /* 7 */ "Add Visits/Appointments", "Edit Visits/Appointments", "Delete Visits/Appointments",
        /* 10 */ "Add Appointment Data", "Edit Appointment Data", "Delete Appointment Data",
        /* 13 */ "Add Services Offered", "Edit Services Offered", "Delete Services Offered",
        /* 16 */ "Add Service Providers", "Edit Service Providers", "Delete Service Providers",
        /* 19 */ "View only Self-Created Sales", "Cancel Documents", "Take Payments",
        /* 22 */ "Apply Adhoc Discounts", "Apply Pre-defined Discounts",
        /* 24 */ "Can Edit Unit Price", "View Other Provider's Data");


    $subGrpNames = "";
    $mainTableNames = "";
    $keyColumnNames = "";
    $myName = "Visits and Appointments";
    $myDesc = "This module helps you to manage your organization's Client Visits and Appointments Scheduling!!";
    $audit_tbl_name = "hosp.hosp_audit_trail_tbl";
    $smplRoleName = "Visits and Appointments Administrator";

    $DefaultPrvldgs1 = array(/* 0 */ "View Visits and Appointments",
        /* 1 */ "View Visits/Appointments", "View Appointments Data", "View Service Providers", "View Services Offered",
        /* 5 */ "View SQL", "View Record History",
        /* 7 */ "Add Visits/Appointments", "Edit Visits/Appointments", "Delete Visits/Appointments",
        /* 10 */ "Add Appointment Data", "Edit Appointment Data", "Delete Appointment Data",
        /* 13 */ "Add Services Offered", "Edit Services Offered", "Delete Services Offered",
        /* 16 */ "Add Service Providers", "Edit Service Providers", "Delete Service Providers",
        /* 19 */ "View only Self-Created Sales", "Cancel Documents", "Take Payments",
        /* 22 */ "Apply Adhoc Discounts", "Apply Pre-defined Discounts",
        /* 24 */ "Can Edit Unit Price", "View Other Provider's Data",
        /* 26 */ "Add List of Diagnosis", "Edit List of Diagnosis", "Delete List of Diagnosis",
        /* 29 */ "View Lab Investigations List", "Edit Lab Investigations List", "Delete Lab Investigations List");
    $smplRoleName1 = "Clinic/Hospital Administrator";
    $myName1 = "Clinic/Hospital";
    $myDesc1 = "This module helps you to manage your Clinic/Hospital's Appointments Scheduling and Data Capturing!";

    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
    checkNAssignReqrmnts($myName1, $myDesc1, $audit_tbl_name, $smplRoleName1, $DefaultPrvldgs1, $subGrpNames, $mainTableNames, $keyColumnNames);
    createRqrdHospLOVs();
}

function createRqrdHospLOVs() {

    $sysLovs = array("Service Types", "Service Providers", "Provider Groups", "Dosage Methods", "Inventory Services"
        , "Diagnosis Types", "Investigation Types", "Laboratory Locations", "Inventory Items", "Recommended Services",
        "Service Provider Groups", "Item UOM"
    );
    $sysLovsDesc = array("Service Types", "Service Providers", "Provider Groups", "Dosage Methods", "Inventory Services"
        , "Diagnosis Types", "Investigation Types", "Laboratory Locations", "Inventory Items", "Recommended Services",
        "Service Provider Groups", "Item UOM"
    );
    $sysLovsDynQrys = array("select distinct trim(to_char(type_id,'999999999999999999999999999999')) a, trim(type_name ||' ('||type_desc||')') b, '' c from hosp.srvs_types order by 2",
        "SELECT distinct trim(to_char(x.prsn_id,'999999999999999999999999999999')) a, 
    (SELECT trim(title || ' ' || sur_name || ', ' || first_name || ' ' || other_names) FROM prs.prsn_names_nos WHERE person_id = x.prsn_id)
    ||'('||(SELECT type_name from hosp.srvs_types WHERE type_id = x.srvs_type_id)||')' b, '' c, srvs_type_id d FROM hosp.srvs_prvdrs x order by 2",
        "SELECT distinct trim(to_char(prvdr_grp_id,'999999999999999999999999999999')) a, prvdr_grp_name b, '' c FROM hosp.prvdr_grps order by 2",
        "",
        "SELECT distinct trim(to_char(item_id,'999999999999999999999999999999')) a, item_code||' ('||item_desc||')' b, '' c FROM inv.inv_itm_list WHERE item_type = 'Services' AND org_id = 6 order by 2",
        "SELECT distinct trim(disease_name) a, symtms b, '' c  FROM hosp.diseases order by 1",
        "SELECT distinct trim(to_char(invstgtn_list_id,'999999999999999999999999999999')) a, invstgtn_name||' ('||invstgtn_desc||')' b, '' c  FROM hosp.invstgtn_list order by 2",
        "",
        "SELECT distinct trim(item_code) a, item_desc b, '' c FROM inv.inv_itm_list WHERE org_id = 6 order by 2",
        "select distinct trim(to_char(type_id,'999999999999999999999999999999')) a, trim(type_name ||' ('||type_desc||')') b, '' c from hosp.srvs_types where sys_code not in ('1-Consultation','2-Investigations','3-Vitals','4-Pharmacy') order by 2",
        "SELECT distinct trim(to_char(prvdr_grp_id,'999999999999999999999999999999')) a, (SELECT prvdr_grp_name FROM hosp.prvdr_grps WHERE prvdr_grp_id = x.prvdr_grp_id) b, '' c, type_id d FROM hosp.prvdr_grp_srvs x order by 2",
        "SELECT (SELECT v.uom_name FROM inv.unit_of_measure v WHERE v.uom_id = x.uom_id) a, (SELECT w.uom_desc FROM inv.unit_of_measure w WHERE w.uom_id = x.uom_id) b,
            '' c, z.org_id d, (SELECT w.item_code FROM inv.inv_itm_list w WHERE w.item_id = x.item_id) e
            FROM inv.inv_itm_list z, inv.itm_uoms x WHERE z.item_id = x.item_id 
            union
            SELECT (SELECT y.uom_name FROM inv.unit_of_measure y WHERE y.uom_id = x.base_uom_id) a, (SELECT y.uom_desc FROM inv.unit_of_measure y WHERE y.uom_id = x.base_uom_id) b,
            '' c, x.org_id d, x.item_code e FROM inv.inv_itm_list x  ORDER BY 1"
    );

    $pssblVals = array(
        "3", "Oral", "To be taken my mouth"
        , "3", "Suppository", "To be taken through the anus, urethra"
        , "3", "External", "External applications"
        , "3", "Injection", "To be injected"
        , "3", "Intra-venous Infusion", "To be infused into the veins"
        , "7", "BOG Clinic", "Bank Of Ghana Clinic Laboratory"
        , "7", "Ridge Hospital", "Ridge Hospital Laboratory"
    );

    createSysLovs($sysLovs, $sysLovsDesc, $sysLovsDynQrys);
    createSysLovsPssblVals($pssblVals, $sysLovs);
}

function loadHotlMdl() {
    $DefaultPrvldgs = array(
        /* 1 */ "View Hospitality Manager", "View Rooms Dashboard",
        /* 2 */ "View Reservations", "View Check Ins", "View Service Types",
        /* 5 */ "View Restaurant", "View Gym",
        /* 7 */ "Add Service Types", "Edit Service Types", "Delete Service Types",
        /* 10 */ "Add Check Ins", "Edit Check Ins", "Delete Check Ins",
        /* 13 */ "Add Applications", "Edit Applications", "Delete Applications",
        /* 16 */ "Add Gym Types", "Edit Gym Types", "Delete Gym Types",
        /* 19 */ "Add Gym Registration", "Edit Gym Registration", "Delete Gym Registration",
        /* 22 */ "View SQL", "View Record History",
        /* 24 */ "Add Table Order", "Edit Table Order", "Delete Table Order", "Setup Tables",
        /* 28 */ "View Complaints/Observations", "Add Complaints/Observations", "Edit Complaints/Observations", "Delete Complaints/Observations",
        /* 32 */ "View only Self-Created Sales", "Cancel Documents", "Take Payments", "Apply Adhoc Discounts", "Apply Pre-defined Discounts",
        /* 37 */ "View Rental Item", "Can Edit Unit Price");

    $subGrpNames = "";
    $mainTableNames = "";
    $keyColumnNames = "";
    $myName = "Hospitality Management";
    $myDesc = "This module helps you to manage your organization's Hospitality Needs!";
    $audit_tbl_name = "hotl.hotl_audit_trail_tbl";
    $smplRoleName = "Hospitality Management Administrator";

    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
}

function loadSelfMdl() {
    $DefaultPrvldgs = array("View Self-Service",
        /* 1 */ "View Internal Payments", "View Payables Invoices", "View Receivables Invoices",
        /* 4 */ "View Leave of Absence", "View Events/Attendances", "View Elections",
        /* 7 */ "View Forums", "View E-Library", "View E-Learning",
        /* 10 */ "View Elections Administration", "View Personal Records Administration", "View Forum Administration",
        /* 13 */ "View Self-Service Administration",
        /* 14 */ "View SQL", "View Record History",
        /* 16 */ "Administer Elections",
        /* 17 */ "Administer Leave",
        /* 18 */ "Administer Self-Service", "Make Requests for Others", "Administer Other's Inbox",
        /* 21 */ "View Comments", "Add Comments", "Edit Comments", "Delete Comments");

    $DefaultPrvldgs1 = array("View Self-Service",
        /* 1 */ "View Internal Payments", "View Payables Invoices", "View Receivables Invoices",
        /* 4 */ "View Leave of Absence", "View Events/Attendances", "View Elections",
        /* 7 */ "View Forums", "View E-Library", "View Comments", "Add Comments");

    $subGrpNames = "";
    $mainTableNames = "";
    $keyColumnNames = "";
    $myName = "Self Service";
    $myDesc = "This module helps your Registered Persons to view and manage their Individual Records when approved!";
    $audit_tbl_name = "self.self_prsn_audit_trail_tbl";

    $smplRoleName = "Self-Service Administrator";
    $smplRoleName1 = "Self-Service (Standard)";
    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName1, $DefaultPrvldgs1, $subGrpNames, $mainTableNames, $keyColumnNames);
}

function loadAcaMdl() {
    $DefaultPrvldgs = array("View Summary Reports", "View Learning/Performance Management",
        /* 1 */ "View Assessment Sheets", "View Task Assignment Setups", "View Groups/Courses/Subjects",
        /* 4 */ "View Position Holders", "View Assessment Periods", "View Assessment Reports Types"
            /* 7 */            );

    $subGrpNames = "";
    $mainTableNames = "";
    $keyColumnNames = "";
    $myName = "Learning/Performance Management";
    $myDesc = "This module helps you to manage your organization's Learning/Performance Assessment Needs!";
    $audit_tbl_name = "aca.aca_audit_trail_tbl";

    $smplRoleName = "Learning/Performance Management Administrator";
    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
}

function loadAttnMdl() {
    $DefaultPrvldgs = array(
        "View Events And Attendance",
        /* 1 */ "View Attendance Records", "View Time Tables", "View Events",
        /* 4 */ "View Venues", "View Attendance Search", "View SQL", "View Record History",
        /* 8 */ "Add Attendance Records", "Edit Attendance Records", "Delete Attendance Records",
        /* 11 */ "Add Time Tables", "Edit Time Tables", "Delete Time Tables",
        /* 14 */ "Add Events", "Edit Events", "Delete Events",
        /* 17 */ "Add Venues", "Edit Venues", "Delete Venues",
        /* 20 */ "Add Event Results", "Edit Event Results", "Delete Event Results",
        /* 23 */ "View Adhoc Registers", "Add Adhoc Registers", "Edit Adhoc Registers", "Delete Adhoc Registers",
        /* 27 */ "View Event Cost", "Add Event Cost", "Edit Event Cost", "Delete Event Cost",
        /* 31 */ "View Complaints/Observations", "Add Complaints/Observations", "Edit Complaints/Observations", "Delete Complaints/Observations",
        /* 35 */ "View only Self-Created Sales", "Cancel Documents", "Take Payments", "Apply Adhoc Discounts", "Apply Pre-defined Discounts",
        /* 40 */ "Can Edit Unit Price"
    );

    $subGrpNames = "";
    $mainTableNames = "";
    $keyColumnNames = "";
    $myName = "Events And Attendance";
    $myDesc = "This module helps you to manage your organization's Events And Attendance!";
    $audit_tbl_name = "attn.attn_audit_trail_tbl";

    $smplRoleName = "Events And Attendance Administrator";
    checkNAssignReqrmnts($myName, $myDesc, $audit_tbl_name, $smplRoleName, $DefaultPrvldgs, $subGrpNames, $mainTableNames, $keyColumnNames);
    createPayRqrdLOVs();
}

function createPayRqrdLOVs() {
    $sysLovs = array("Item Sets for Payments(Enabled)", "Person Sets for Payments(Enabled)",
        "Pay Run Names/Numbers", "Retro Pay Items", "Pay Balance Items");
    $sysLovsDesc = array("Item Sets for Payments(Enabled)", "Person Sets for Payments(Enabled)",
        "Quick/Mass Pay Run Names/Numbers", "Retro Pay Items", "Pay Balance Items");
    $sysLovsDynQrys = array("select distinct trim(to_char(z.hdr_id,'999999999999999999999999999999')) a, z.itm_set_name b, '' c, z.org_id d, '' e, '' f, y.user_role_id g from pay.pay_itm_sets_hdr z, pay.pay_sets_allwd_roles y where z.hdr_id = y.itm_set_id and z.is_enabled='1' order by z.itm_set_name",
        "select distinct trim(to_char(z.prsn_set_hdr_id,'999999999999999999999999999999')) a, z.prsn_set_hdr_name b, '' c, z.org_id d, '' e, '' f, y.user_role_id g  from pay.pay_prsn_sets_hdr z, pay.pay_sets_allwd_roles y where z.prsn_set_hdr_id = y.prsn_set_id and z.is_enabled='1' order by z.prsn_set_hdr_name",
        "select distinct mass_pay_name a, mass_pay_desc b, '' c, org_id d, mass_pay_id e from pay.pay_mass_pay_run_hdr where run_status='1' order by mass_pay_id DESC",
        "select '' || item_id a, item_code_name b, '' c, org_id d from org.org_pay_items where is_retro_element='1' and (item_id NOT IN (select distinct z.retro_item_id from org.org_pay_items z)) order by item_code_name",
        "select item_code_name a, item_desc||' ('|| item_id||')' b, '' c, org_id d from org.org_pay_items where item_maj_type='Balance Item' order by item_code_name");
    $pssblVals = array();

    createSysLovs($sysLovs, $sysLovsDynQrys, $sysLovsDesc);
    //createSysLovsPssblVals($sysLovs, $pssblVals);
}

function loadMcfMdl() {
    
}

function createSysLovs($sysLovs, $sysLovsDesc, $sysLovsDynQrys) {
    for ($i = 0; $i < count($sysLovs); $i++) {
        $lovID = getLovID($sysLovs[$i]);
        if ($lovID <= 0) {
            if ($sysLovsDynQrys[$i] == "") {
                createLovNm($sysLovs[$i]
                        , $sysLovsDesc[$i], '0 ', "", "SYS", '1');
            } else {
                createLovNm($sysLovs[$i], $sysLovsDesc[$i]
                        , '1', $sysLovsDynQrys[$i], "SYS", '1');
            }
        } else {
            if ($sysLovsDynQrys[$i] != "") {
                updateLovNm($lovID, true, $sysLovsDynQrys[$i], "SYS", true);
            }
        }
    }
}

function get_all_OrgIDs() {
    $strSql = "SELECT distinct org_id FROM org.org_details";
    $result = executeSQLNoParams($strSql
    );
    $allwd = ",";
    while ($row = loc_db_fetch_array($result)) {
        $allwd .= $row[0] . ",";
    }

    return $allwd;
}

function createSysLovsPssblVals($pssblVals, $sysLovs) {
    $allwd = get_all_OrgIDs();
    for ($i = 0; $i < count($pssblVals); $i += 3) {
        //, $pssblVals[ $i + 2]
        if (getPssblValID($pssblVals[$i + 1], getLovID($sysLovs[(int) $pssblVals[$i]])) <= 0) {
            createPssblValsForLov(getLovID($sysLovs[(int) $pssblVals[$i]]), $pssblVals[$i + 1], $pssblVals[$i + 2], '1', $allwd);
        }
    }
}

function createLovNm($lovNm, $lovDesc, $isDyn
, $sqlQry, $dfndBy, $isEnbld) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $sqlStr = "INSERT INTO gst.gen_stp_lov_names(" .
            "value_list_name, value_list_desc, is_list_dynamic, " .
            "sqlquery_if_dyn, defined_by, created_by, creation_date, last_update_by, " .
            "last_update_date, is_enabled) " .
            "VALUES ('" . loc_db_escape_string($lovNm) . "', '" . loc_db_escape_string($lovDesc) .
            "', '" . $isDyn . "', '" . loc_db_escape_string($sqlQry) . "', '" . loc_db_escape_string($dfndBy) .
            "', " . $usrID . ", '" . $dateStr . "', " . $usrID .
            ", '" . $dateStr . "', '" . $isEnbld . "')";
    execUpdtInsSQL($sqlStr);
}

function updateLovNm($lovID, $isDyn, $sqlQry, $dfndBy, $isEnbld) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $sqlStr = "UPDATE gst.gen_stp_lov_names SET " .
            "is_list_dynamic='" . cnvrtBoolToBitStr($isDyn) . "', " .
            "sqlquery_if_dyn='" . loc_db_escape_string($sqlQry) .
            "', defined_by='" . loc_db_escape_string($dfndBy) .
            "', last_update_by=" . $usrID . ", " .
            "last_update_date='" . $dateStr .
            "', is_enabled='" . cnvrtBoolToBitStr($isEnbld) .
            "' WHERE value_list_id = " . $lovID;
    execUpdtInsSQL($sqlStr);
}

function createPssblValsForLov($lovID, $pssblVal, $pssblValDesc, $isEnbld, $allwd) {
    global $usrID;
    $dateStr = getDB_Date_time();
    $sqlStr = "INSERT INTO gst.gen_stp_lov_values(" .
            "value_list_id, pssbl_value, pssbl_value_desc, " .
            "created_by, creation_date, last_update_by, last_update_date, is_enabled, allowed_org_ids) " .
            "VALUES (" . $lovID . ", '" . loc_db_escape_string($pssblVal) . "', '" . loc_db_escape_string($pssblValDesc) .
            "', " . $usrID . ", '" . $dateStr . "', " . $usrID .
            ", '" . $dateStr . "', '" . $isEnbld . "', '" . loc_db_escape_string($allwd) . "')";
    $result = execUpdtInsSQL($sqlStr
    );
}

?>
