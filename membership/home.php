<?php
session_start();
require '../API/vendor/autoload.php';
$newDataRequest = new UserApi\viewData();

$year = date('Y');
$unique_id = $_SESSION['unique_id'];
?>


<header>EDIT PROFILE</header>
<div class="grid_sx">
    <input hidden value="<?php echo $unique_id; ?>" id="userId" />
    <div class="profile">
        <?php
        $data = json_decode($newDataRequest->getPersonalData($unique_id));
        if ($data == "" || $data == 'Error Occurred' || $data == 'No Records Available') {
            echo "<header class='danger'>AN ERROR OCCURED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
        } else {
            foreach ($data as $item) {
                $unique_id = $item->UniqueId;
                $Firstname = $item->Firstname;
                $Othername = $item->Othername;
                $Age = $item->Age;
                $Position = $item->Position;
                $contact = $item->contact;
                $email = $item->email;
                $image = $item->image;
                $Address = $item->Address;
                $Baptism = $item->Baptism;
                $membership_start = $item->membership_start;
                $username = $item->username;
                $gender = $item->gender;
                $occupation = $item->occupation;
                $About = $item->About;
                $_SESSION['userImage'] = $image;
                ?>
                <div class="flex profile_status">
                    <div class="cover" style="position:relative;">
                        <img src="../API/Images_folder/users/<?php echo $image; ?>" alt="" id="cover_profile" />
                        <div class="loader_btn">
                        <div class="loader_wrapper">
                            <div class="load-3">
                                <div class="line"></div>
                                <div class="line"></div>
                                <div class="line"></div>
                            </div>
                            <div class="text">
                                <p style="color:crimson"></p>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="details">
                        <button id="browseButton">Upload new photo</button>
                        <p>At least 800 x 800 px recommended.</p>
                        <p>JPG OR PNG is allowed</p>
                    </div>
                </div>
                <div class="personal_details">
                    <div class="personal_details_info">
                        <div class=" flex title">
                            <p>Personal Details</p>
                            <div class="flex button"><i class="fas fa-edit"></i>Edit</div>
                        </div>
                        <div class="info">
                            <div class="feild">
                                <label>Full name</label>
                                <p><?php echo $Firstname . ' ' . $Othername; ?></p>
                            </div>
                            <div class="feild">
                                <label>Email</label>
                                <p><?php echo $email; ?></p>
                            </div>
                            <div class="feild">
                                <label>Phone</label>
                                <p><?php echo $contact; ?> </p>
                            </div>
                        </div>
                    </div>



                    <div class="location">
                        <div class="flex title">
                            <p>Location</p>
                        </div>
                        <div class="info_bar">
                            <div class="flex info_bar">
                                <div class="flex compass">
                                    <i class="fas fa-compass"></i>
                                    <input type="text" disabled placeholder="<?php echo $Address; ?>"
                                        value="<?php echo $Address; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bio">
                        <div class=" flex title">
                            <p>Bio</p>
                            <div class="flex button"><i class="fas fa-edit"></i>Edit</div>
                        </div>
                        <div class="bio_data">
                            <p><?php
                            echo $About;
                            ?>
                        </div>
                    </div>


                </div>
            </div>
            <div class="status">
                <header>Complete your profile</header>
                <?php
                $val = 10;
                $cnt = 0;
                $img_percent = 0;
                $bio_percent = 0;
                $location_percent = 0;
                if (strlen($image) > 10) {
                    $img_percent = 10;
                    $val += 10;
                }
                if (strlen($contact) > 10) {
                    $cnt += 5;
                    $val += 5;
                }
                if (strlen($About) > 10) {
                    $bio_percent = 10;
                    $val += 10;
                }
                if (strlen($Address) > 3) {
                    $location_percent = 10;
                    $val += 10;
                }
                if (strlen($email) > 10) {
                    $cnt += 5;
                    $val += 5;
                }
                ?>
                <div class="gauge" style="--percent:<?php echo 36 * (($val * 2) / 10); ?>deg">
                    <div class="details">
                        <p><?php echo $val * 2; ?>%</p>
                    </div>

                </div>
                <div class="checklist">

                    <div class="flex item">
                        <i class="fas fa-check"></i>
                        <p>Setup account</p>
                        <p>10%</p>
                    </div>
                    <div class="flex item">
                        <i class="fas fa-check"></i>
                        <p>Upload your photo</p>
                        <p><?php echo $img_percent * 10; ?>%</p>
                    </div>
                    <div class="flex item">
                        <i class="fas fa-check"></i>
                        <p>Personal Info</p>
                        <p><?php echo $bio_percent * 10; ?>%</p>
                    </div>
                    <div class="flex item "><!--uncheck-->
                        <i class="fas fa-check"></i>
                        <p>location</p>
                        <p><?php echo $location_percent * 10; ?>%</p>
                    </div>
                    <div class="flex item">
                        <i class="fas fa-check"></i>
                        <p>Bio</p>
                        <p><?php echo $cnt * 10; ?>%</p>

                    </div>
                </div>
            </div>

            <div class="event_menu_add">
                <form>
                    <header>Membership form</header>
                    <p class="error_information"></p>
                    <div class="container_event">
                        <div class="cate_view">
                            <div class="field">
                                <label>First name</label>
                                <input name="Fname" type="text" placeholder="" value="<?php echo $Firstname; ?>" required />
                            </div>
                            <div class="field">
                                <label>Other name</label>
                                <input name="Oname" type="text" placeholder="" value="<?php echo $Othername; ?>" required />
                            </div>

                        </div>
                        <div class="field">
                            <label>contact</label>
                            <input name="contact" type="text" placeholder="" value="<?php echo $contact; ?>" required />
                        </div>

                        <div class="cate_view">
                            <div class="field">
                                <label>Email</label>
                                <input name="Email" type="email" placeholder="" value="<?php echo $email; ?>" required />
                            </div>
                            <div class="field">
                                <label>Location (city,town and street)</label>
                                <input name="location" type="text" placeholder="" value="<?php echo $Address; ?>" required />
                            </div>
                        </div>
                        <div class="field_e">
                            <textarea name="About"><?php echo $About; ?></textarea>
                        </div>

                        <input name="delete_key" type="text" value="<?php echo $unique_id; ?>" hidden />
                        <button>create Activity</button>
                    </div>
                </form>

            </div>

            <?php
            }
        }
        ?>