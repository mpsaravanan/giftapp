<?php if(count($data)>=1){ ?>
<table border="1">
   <tr style="background-color:#F7A52D;color:#fff;">
        <th>#</th>
        <th>Req Id</th>
        <th>City</th>
        <th>User Name</th>
        <th>Mobile No</th>
        <th>Source</th>
        <th>Status</th>
        <th>Inserted Time</th>
   </tr>
    <?php
    $i=1;
    foreach($data as $cron){
        ?>
        <tr style="">
            <td><?php echo $i; ?></td>
            <td><?php echo $cron['req_id'];?></td>
            <td><?php echo $cron['city'];?></td>
            <td><?php echo $cron['user_name'];?></td>
            <td><?php echo $cron['phone_no'];?></td>
            <td><?php echo $cron['source'];?></td>
            <td><?php echo $cron['status'];?></td>
            <td><?php echo $cron['inserted_time'];?></td>
        </tr>
        <?php
        $i++;
    }
    ?>
    </table>
    <?php
}
else{
    ?>
    <table border="1">
    <tr style="background-color:#F7A52D;color:#fff;">
        <th>#</th>
        <th>Req Id</th>
        <th>City</th>
        <th>User Name</th>
        <th>Mobile No</th>
        <th>Source</th>
        <th>Status</th>
        <th>Inserted Time</th>
   </tr>
       <tr style="">
            <th colspan="12">No records Found</th>
       </tr>
    <?php
}
?>