<?php
include_once ('../API/notifications & token & history/autoloader.php');
$newDataRequest = new viewData();
$val = 1;
if (isset($_GET['page'])) {
    $val = $_GET['page'];
}

?>

<div class="profile_main">
<div class="navigation Filter" >

    <div class="item">
        <p>Name <i class="fas fa-filter"></i></p>
    </div>
    <div class="list">
        <div class="item" data-filter='Year'>
            <p><i class="fas fa-"></i>Year <input type="date" class="filter_date"/></p>
        </div>
        <div class="item" data-filter='modified'>
            <p><i class="fas fa-edit"></i>Date modified </p>
        </div>
        <div class="item" data-filter='Ascending'>
            <p><i class="fas fa-arrow-up"></i>Ascending </p>
        </div>
        <div class="item" data-filter='Descending'>
            <p><i class="fas fa-arrow-down"></i>Descending </p>
        </div>
    </div>

<div class="filter_wrapper mini">
    <div style="height:40px;" class="flex">
        <div class="ux_search_bar">
            <button id="searchBtn"><i class="fas fa-search" aria-hidden></i></button>
            <input type="search_data" type="search" id="searchInput" name="search" placeholder="...search here" />
        </div>
    </div>
</div>

</div>
    <div class="grid_sx tithebook">
        <div class="profile">
            <div class="tithe_list ancc_list">
            <?php
                    $data = $newDataRequest->viewList();
                    if($data == 'No Records Available'){
                        echo '<h1>Records of announcement Data is not available, upload them by clicking on the +new element</h1>';
                    }else
                    if($data){
                       $destructure = json_decode($data); 
                       foreach($destructure as $item){
                        $object = new stdClass();
                        $object->id = $item->Id;
                        $object->title = $item->name;
                        $object->receiver = $item->receiver;
                        $object->date = $item->date;
                        $object->message = $item->message;

                        $objectFile = json_encode($object);
                        $status = "";
                        if($item->status == 'active'){
                            $status = 'active';
                        }

                        if($item->file == " " || $item->file ==""){
                            echo "<div class='annc_item'>
                            <div class='flex button'>
                                <div class=' flex title'>
                                    <h1>".$item->name."</h1>
                                    <div class='flex button'><i class='fas fa-date'></i>".$item->date."</div>
                                </div>
                            </div>
        
                            <div class='div_content'>
                                <p>".$item->message."</p>
                            </div>
                            <div class=' flex options title'>
                                <div class='edit flex'>
                                    <i class='fas fa-edit Update_item' data-information='$objectFile'></i>
                                    <p>Edit</p>
                                     <div class='toggle_mode $status' data-id='".$item->Id."'>
                                        <svg xmlns='http://www.w3.org/2000/svg' class='on' height='24' fill='green'
                                            viewBox='0 -960 960 960' width='24'>
                                            <path
                                                d='M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm400-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM480-480Z' />
                                        </svg>
                                        <svg xmlns='http://www.w3.org/2000/svg' class='off' height='24' fill='red'
                                            viewBox='0 -960 960 960' width='24'>
                                            <path
                                                d='M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm200-120Z' />
                                        </svg>
                                    </div>
                                </div>                        
                                <div class='edit flex'>
                                    <i class='fas fa-trash delete_item' data-id='".$item->Id."'></i>
                                    <p>Remove</p>
                                </div>
                            </div>
        
                        </div>";
                        }else{

                            echo 
                            "
                            <div class='annc_item'>
                               <div class='flex'>
                                <img src='../API".$item->file."' alt='' />
                                <div class='img_details'>
                                    <div class='flex button'>
                                     <div class=' flex title'>
                                         <h1>".$item->name."</h1>
                                         <div class='flex button'><i class='fas fa-date'></i>".$item->date."</div>
                                     </div>
                                    </div>
                                    <div class='div_content'>
                                     <p>".$item->message."</p>
                                    </div>
                                </div>
                              </div> 
                                <div class=' flex options title'>
                                <div class='edit flex'>
                                    <i class='fas fa-edit Update_item' data-information='$objectFile'></i>
                                    <p>Edit</p>
                                     <div class='toggle_mode' data-id=".$item->Id.">
                                        <svg xmlns='http://www.w3.org/2000/svg' class='on' height='24' fill='green'
                                            viewBox='0 -960 960 960' width='24'>
                                            <path
                                                d='M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm400-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM480-480Z' />
                                        </svg>
                                        <svg xmlns='http://www.w3.org/2000/svg' class='off' height='24' fill='red'
                                            viewBox='0 -960 960 960' width='24'>
                                            <path
                                                d='M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm200-120Z' />
                                        </svg>
                                    </div>
                                </div>                        
                                <div class='edit flex'>
                                    <i class='fas fa-trash delete_item' data-id=".$item->Id."></i>
                                    <p>Remove</p>
                                </div>
                                </div>
                            </div>                       
                                ";
                        }
                        
                       }
                    }
                    
                ?>
            </div>
        </div>
    </div>
</div>
<div class="event_menu_add">
    <h1 class="error_information danger"></h1>
    <header>Create Notification</header>
    <form>
    <div class="container_event">
    <div class="field">
            <label>Tile</label>
            <input type="text"  name="name"/>
        </div>
        <div class="field_e">
            <label>Enter message</label>
            <textarea name="message">...</textarea>
        </div>
        <div class="field">
            <label>Add file</label>
            <input type="file"  name="file"/>
        </div>

        <div class="field">
            <label>Send-to</label>
            <input type="text" name="receiver" />
        </div>

        <div class="field">
            <label>Schedule Update</label>
            <input type="date" name="date" />
        </div>
        <input hidden name="delete_key" />
        <button>Record message</button>
    </div>
    </form>
</div>

<div class="add_event" data-menu="event">
    <i>+</i>
    <p>New</p>
</div>


<div class="page_sys">

    <header>
        <?php
        $total = $newDataRequest->HistoryPages();
        if ((round($total / 6)) > 1) {
            echo 'Pages:';
        }
        ?>
        <div class="pages">
            <?php
            $loop = 0;
            if ((round($total / 6)) > 1) {
                if (($total / 6) > 6) {
                    $loop = 6;
                } else {
                    $loop = ($total / 6);
                }
                for ($i = 0; $i < $loop; $i++) {
                    $class = "";
                    if ($i == $val - 1) {
                        $class = 'active';
                    }
                    echo '<div class="' . $class . '">' . ($i + 1) . '</div>';
                }
                if ($loop == 6) {
                    echo '<span>......</span><div>' . $total . '</div>';
                }
            }
            ?>
        </div>
    </header>
</div>
