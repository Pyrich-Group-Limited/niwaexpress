<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class Utility extends Model
{
    public static function settings()
    {
        $data = DB::table('settings');
        $data = $data->where('created_by', '=', 1);
        $data     = $data->get();


        $settings = [
            "site_currency" => "NGN",
            "site_currency_symbol" => "₦",
            "site_currency_symbol_position" => "pre",
            "site_date_format" => "M j, Y",
            "site_time_format" => "g:i A",
            "company_name" => "",
            "company_address" => "",
            "company_city" => "",
            "company_state" => "",
            "company_zipcode" => "",
            "company_country" => "",
            "company_telephone" => "",
            "company_email" => "",
            "company_email_from_name" => "",
            "invoice_prefix" => "#INVO",
            "invoice_color" => "ffffff",
            "proposal_prefix" => "#PROP",
            "proposal_color" => "ffffff",
            "bill_prefix" => "#BILL",
            "expense_prefix" => "#EXP",
            "bill_color" => "ffffff",
            "customer_prefix" => "#CUST",
            "vender_prefix" => "#VEND",
            "footer_title" => "",
            "footer_notes" => "",
            "invoice_template" => "template1",
            "bill_template" => "template1",
            "proposal_template" => "template1",
            "registration_number" => "",
            "vat_number" => "",
            "default_language" => "en",
            "enable_stripe" => "",
            "enable_paypal" => "",
            "paypal_mode" => "",
            "paypal_client_id" => "",
            "paypal_secret_key" => "",
            "stripe_key" => "",
            "stripe_secret" => "",
            "decimal_number" => "2",
            "tax_type" => "",
            "shipping_display" => "on",
            "journal_prefix" => "#JUR",
            "display_landing_page" => "on",
            "employee_prefix" => "#EMP00",
            'leave_status' => '1',
            "bug_prefix" => "#ISSUE",
            'title_text' => '',
            'footer_text' => '',
            "company_start_time" => "09:00",
            "company_end_time" => "18:00",
            'gdpr_cookie' => 'off',
            "interval_time" => "",
            "zoom_apikey" =>"",
            "zoom_apisecret" => "",
            "slack_webhook" =>"",
            "telegram_accestoken" => "",
            "telegram_chatid" =>"",
            "enable_signup" => "on",
            'cookie_text' => 'We use cookies to ensure that we give you the best experience on our website. If you continue to use this site we will assume that you are happy with it.
',
            "company_logo_light" => "logo-light.png",
            "company_logo_dark" =>  "logo-dark.png",
            "company_favicon" => "favicon.png",
            "cust_theme_bg" => "on",
            "cust_darklayout" => "off",
            "color" => "",
            "SITE_RTL" => "off",
            "purchase_prefix" => "#PUR",
            "purchase_color" => "ffffff",
            "purchase_template" => "template1",
            "pos_color" => "ffffff",
            "pos_template" => "template1",
            "pos_prefix" => "#POS",

            "storage_setting" => "local",
            "local_storage_validation" => "jpg,jpeg,png,xlsx,xls,csv,pdf",
            "local_storage_max_upload_size" => "2048000",
            "s3_key" => "",
            "s3_secret" => "",
            "s3_region" => "",
            "s3_bucket" => "",
            "s3_url"    => "",
            "s3_endpoint" => "",
            "s3_max_upload_size" => "",
            "s3_storage_validation" => "",
            "wasabi_key" => "",
            "wasabi_secret" => "",
            "wasabi_region" => "",
            "wasabi_bucket" => "",
            "wasabi_url" => "",
            "wasabi_root" => "",
            "wasabi_max_upload_size" => "",
            "wasabi_storage_validation" => "",

            "purchase_logo" =>"",
            "proposal_logo" =>"",
            "invoice_logo" =>"",
            "pos_logo" =>"",
            "contract_prefix" => "#CON",

            "barcode_type" => "code128",
            "barcode_format" =>"css",


            'new_user' => '1',
            'new_client' => '1',
            'new_support_ticket' => '1',
            'lead_assigned' => '1',
            'deal_assigned' =>'1',
            'new_award' =>'1',
            'customer_invoice_sent' =>'1',
            'new_invoice_payment' =>'1',
            'new_payment_reminder' =>'1',
            'new_bill_payment' =>'1',
            'bill_resent' =>'1',
            'proposal_sent' =>'1',
            'complaint_resent' =>'1',
            'leave_action_sent' =>'1',
            'payslip_sent' => '1',
            'promotion_sent' =>'1',
            'resignation_sent' => '1',
            'termination_sent' =>'1',
            'transfer_sent' =>'1',
            'trip_sent' => '1',
            'vender_bill_sent' => '1',
            'warning_sent' =>'1',
            'new_contract' =>'1',

            'vat_gst_number_switch' =>'off',
            'google_calendar_enable' => 'off',
            'google_calender_json_file'=>'',

            'enable_cookie'=>'on',
            'necessary_cookies'=>'on',
            'cookie_logging'=>'on',
            'cookie_title'=>'We use cookies!',
            'cookie_description'=>'Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it',
            'strictly_cookie_title'=>'Strictly necessary cookies',
            'strictly_cookie_description'=>'These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly',
            'more_information_description'=>'For any queries in relation to our policy on cookies and your choices, please contact us',
            'contactus_url'=>'#',

            'twilio_sid'=>'',
            'twilio_token'=>'',
            'twilio_from'=>'',
            'ai_chatgpt_enable' => 'off',
            'chat_gpt_key' => '',
            "ip_restrict" => "off",



        ];

        foreach($data as $row)
        {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }

}
    ?>