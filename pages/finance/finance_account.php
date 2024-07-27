
<?php
include_once ('../../API/finance/autoloader.php');
$newDataRequest = new viewData();
if(isset($_GET['data_page'])){
$num = $_GET['data_page'];
}else{
    $num = 1;
}
?>

    <div class="part_1">
        <div class="middle">
            <div class="cards">
                <?php
                $data = $newDataRequest->Accounts_list_Card();
                print_r($data);
                ?>
            </div>
            <!-- monthly report -->
            <div class="monthly-report">
                <div class="report">
                    <h3>Income</h3>
                    <div>
                        <details>
                            <h1>$19,230</h1>
                            <h4 class="success">+4.6%</h4>
                        </details>
                        <p class="text-muted">Compared to $18,384 last month</p>
                    </div>
                </div>
                <div class="report">
                    <h3>Expenses</h3>
                    <div>
                        <details>
                            <h1>$9,113</h1>
                            <h4 class="danger">-6.2%</h4>
                        </details>
                        <p class="text-muted">Compared to $9,715 last month</p>
                    </div>
                </div>
                <div class="report">
                    <h3>Cashback</h3>
                    <div>
                        <details>
                            <h1>$4,390</h1>
                            <h4 class="success">+2.9%</h4>
                        </details>
                        <p class="text-muted">Compared to $4,266 last month</p>
                    </div>
                </div>
                <div class="report">
                    <h3>Income</h3>
                    <div>
                        <details>
                            <h1>$86,374</h1>
                            <h4 class="danger">-5.2%</h4>
                        </details>
                        <p class="text-muted">Compared to $91,111 last month</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="right">
            <table id="account_chart">

            <?php
                    $data = $newDataRequest->Accounts_list_Data(); 
                    if($data == "" || $data == 'Error Occurred' || $data == 'Not Records Available'){
                        echo "<header class='danger'>AN ERROR OCCURED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                    }else{
                        echo "<thead>
                    <tr>
                       <th>Description</th>
                        <th>Date</th>
                        <th>category</th>
                        <th>P%</th>
                        <th>Amount</th>
                        <th>Balance</th>
                    </tr>
                </thead><tbody>";
                        print_r($data);
                        echo "</tbody>";
                    }
                ?>
            </table>
        </div>
    </div>
