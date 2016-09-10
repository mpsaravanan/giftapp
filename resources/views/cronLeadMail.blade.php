<?php if(count($data)>=1){ ?>
<table border="1">
   <tr style="background-color:#F7A52D;color:#fff;">
        <th>#</th>
        <th>Project Id</th>
        <th>Project Name</th>
        <th>Builder Name</th>
        <th>Lead Receiver Name</th>
        <th>Lead Receiver Email</th>
        <th>Lead Receiver Mobile</th>
        <th>Campaign Type</th>
        <th>Count</th>
   </tr>
    <?php
    $i=1;
    foreach($data as $cron){
        
        ?>
        <tr style="">
            <td><?php echo $i; ?></td>
            <td><?php echo $cron['project_id'];?></td>
            <td><?php echo $cron['project_name'];?></td>
            <td><?php echo $cron['builder_name'];?></td>
            <td><?php echo $cron['leadreceiver_name'];?></td>
            <td><?php echo $cron['leadreceiver_email'];?></td>
            <td><?php echo $cron['leadreceiver_phone'];?></td>
            <td><?php echo $cron['vl_status'];?></td>
            <td><?php echo $cron['count_lead'];?></td>
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
            <th>Project Id</th>
            <th>Project Name</th>
            <th>Builder Name</th>
            <th>Lead Receiver Name</th>
            <th>Lead Receiver Email</th>
            <th>Lead Receiver Mobile</th>
            <th>Campaign Type</th>
            <th>Count</th>
       </tr>
       <tr style="background-color:#F7A52D;color:#fff;">
            <th colspan="9">No records Found</th>
       </tr>
    
    <?php
}
?>