<?php

return [
    'welcome_page' => 'Welcome to website :name',
    'copyright'	=> 'Copyright :name . All rights Reserved.',
    'verification_email' => 'Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.',
    'success' => [
        'new_data'		=> 'Data Saved Successfully.',
        'edit_data'		=> ':title has changed Successfully.',
        'delete_data'	=> ':title has removed Successfully!',
        'login'         => 'You have successfully logged in!',
        'sent_data'     => 'Data has been sent Successfully',
        'request_role'  => 'You have accepted user :user to access rights as :role.',
        'verification_email' => 'A new verification link has been sent to the email address you provided during registration.',
    ],
    'error' => [
        'new_data'		=> 'Data was not saved successfully.',
        'edit_data'		=> ':title was not changed successfully.',
        'delete_data'	=> ':title was not removed successfully!',
        'login'         => 'You failed to logged in!',
        'cancel'        => ':title has not been cancelled!.',
        'unverified_email' => 'Sorry, your email has not been verified. You will be directed to a verification page.',
        'unexpected'    => 'Sorry, looks like there are some errors detected, please try again.',
        'request_role'  => 'No request to change access rights!',
    ],
    'warning' => [
        'no_selected_data' => 'No data selected!',
        'no_data' => 'Data not found!',
        'no_notification' => 'Notification Not Found!',
        'cancel' => 'Are you sure you would like to cancel?',
        'request_role'  => ':user request to change access rights to :role has been accepted by :approver.',
    ],
    'notice' => [
        'change_role' => 'Immediately Change Your User Role!',
        'role_notif'  => 'Please note that reducing a user role rank, that user will lose all priviledges that was assigned to the previous role.'
    ],
    'permissions' => [
        'log-viewer' => 'View Logs'
    ],
    'notification' => [
        'new_user'  => 'user :attribute has just registered',
        'role_request' => 'User :attribute wants to request access rights as :attribute2',
        'empty'     => 'There are no new notifications',
    ]
];
