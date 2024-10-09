<?php
session_start();
?>
<div class="profile_main">
    <header>Security Status</header>
    <div class="grid_sx tithebook">
        <div class="profile">
            <div class="personal_details">
                <div class="location">
                    <div class="flex title">
                        <p>Request for a new password</p>
                    </div>
                    <div class="info_bar">
                        <div class="flex info_bar">
                            <div class="flex compass">
                                <i class="fas fa-paper-plane"></i>
                                <input type="email" name="Email" placeholder="Enter your email address.." />
                            </div>
                            <button id="request_btn" data-value="<?php echo $_SESSION['unique_id']; ?>">Make a
                                request</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>