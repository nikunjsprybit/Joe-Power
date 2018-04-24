<?php
/*
*Save the sms information to rentals club api account
*/
function rcapi_retrive_sms(){
    
    $token= rcapi_retrive_token();
    
    $url="http://www.rentalsclub.org/wp-json/rcapi/v1/sms/?access_token=".$token;
    $arguments = array(
	'method' => 'GET',
	'timeout' => 45,
	'redirection' => 5,
	'httpversion' => '1.0',
	'blocking' => true,
	'headers' => array(),
	'cookies' => array()
    );
    $response= wp_remote_post($url,$arguments);
    $body=  wp_remote_retrieve_body($response);
    return $body;
 
}




/*
*Save the sms information to rentals club api account
*/
function rcapi_save_sms($sms_content,$use_sms=array()){
    
    $token= rcapi_retrive_token();
    
    $values_array=array(
        "sms_content"   =>  $sms_content,
        "use_sms"       =>  $use_sms,
    );
    $url="http://www.rentalsclub.org/wp-json/rcapi/v1/sms/?access_token=".$token;
    $arguments = array(
	'method' => 'POST',
	'timeout' => 45,
	'redirection' => 5,
	'httpversion' => '1.0',
	'blocking' => true,
	'headers' => array(),
	'body' => $values_array,
	'cookies' => array()
    );
   $response= wp_remote_post($url,$arguments);
   

    return  json_decode( wp_remote_retrieve_body($response) ,true)  ;
 
}




if(!function_exists('wpestate_sms_notice_managment')):
    function wpestate_sms_notice_managment(){

       $sms_data =( rcapi_retrive_sms());
       $sms_data = json_decode($sms_data,true);


        $sms_array=array(
            'new_user'                  =>  __('New user  notification','wpestate'),
            'admin_new_user'            =>  __('New user admin notification','wpestate'),
            'password_reset_request'    =>  __('Password Reset Request','wpestate'),
            'password_reseted'          =>  __('Password Reseted','wpestate'),
            'approved_listing'          =>  __('Approved Listings','wpestate'),
            'admin_expired_listing'     =>  __('Admin - Expired Listing','wpestate'),
            'paid_submissions'          =>  __('Paid Submission','wpestate'),
            'featured_submission'       =>  __('Featured Submission','wpestate'),
            'account_downgraded'        =>  __('Account Downgraded','wpestate'),
            'membership_cancelled'      =>  __('Membership Cancelled','wpestate'),
            'free_listing_expired'      =>  __('Free Listing Expired','wpestate'),
            'new_listing_submission'    =>  __('New Listing Submission','wpestate'),
            'recurring_payment'         =>  __('Recurring Payment','wpestate'),
            'membership_activated'      =>  __('Membership Activated','wpestate'),
            'agent_update_profile'      =>  __('Update Profile','wpestate'),
            'bookingconfirmeduser'      =>  __('Booking Confirmed - User','wpestate'),
            'bookingconfirmed'          =>  __('Booking Confirmed','wpestate'),
            'bookingconfirmed_nodeposit'=>  __('Booking Confirmed - no deposit','wpestate'),
            'inbox'                     =>  __('Inbox- New Message','wpestate'),
            'newbook'                   =>  __('New Booking Request','wpestate'),
            'mynewbook'                 =>  __('User - New Booking Request','wpestate'),
            'newinvoice'                =>  __('Invoice generation','wpestate'),
            'deletebooking'             =>  __('Booking request rejected','wpestate'),
            'deletebookinguser'         =>  __('Booking Request Cancelled','wpestate'),
            'deletebookingconfirmed'    =>  __('Booking Period Cancelled ','wpestate'),
            'new_wire_transfer'         =>  __('New wire Transfer','wpestate'),
            'admin_new_wire_transfer'   =>  __('Admin - New wire Transfer','wpestate'),
        );
        
        
        print '<div class="email_row">'.__('Global variables: %website_url as website url,%website_name as website name, %user_email as user_email, %username as username','wpestate').'</div>';
        print '<input type="hidden" name="is_club_sms" value="1">';
        
        
        
        
        $cache_array                =   array('no','yes');
        $sms_verification_symbol    =   wpestate_dropdowns_theme_admin($cache_array,'sms_verification');
        print'<div class="estate_option_row">
            <div class="label_option_row">'.__('Enable User SMS Verification','wpestate').'</div>
            <div class="option_row_explain">'.__('Select default country','wpestate').'</div>    
                <select id="sms_verification" name="sms_verification">
                    '.$sms_verification_symbol.'
                </select>
        </div>';
        
        
        
        
        foreach ($sms_array as $key=>$label ){

            print '<div class="estate_option_row">';
            $value          = stripslashes( get_option('wp_estate_'.$key,'') );
            $value_subject  = stripslashes( get_option('wp_estate_subject_'.$key,'') );
            
         
            
            
            print '<input type="checkbox" class="admin_checker" name="use_sms['.$key.']" ';
            if( isset($sms_data['use_sms'][$key]) && $sms_data['use_sms'][$key]==1 ){
               print ' checked ';
            }
            print ' value="1"></input>';
            
            
            
            print '<label class="label_option_row"  for="use_sms_'.$key.'">'.__('Send this SMS','wpestate').'</label></br></br>';
                 
            print '<label class="label_option_row"  for="'.$key.'">'.__('SMS for','wpestate').' '.$label.'</label>';
            print '<div class="option_row_explain">'.__('Select default country','wpestate').'</div>    ';

            $sms_content='';
            
            if(isset($sms_data['sms_content'][$key])){
                $sms_content = stripslashes($sms_data['sms_content'][$key]);
            }
            print '<textarea rows="10" style="width:100%;" name="sms_content['.$key.']">'.$sms_content.'</textarea>';
            print '<div class="extra_exp"> '.wpestate_emails_extra_details($key).'</div>';
            print '</div>';

        }

        print'<p class="submit">
               <input type="submit" name="submit" id="submit" class="button-primary"  value="'.__('Save Changes','wpestate').'" />
            </p>';

       
    }
endif;
