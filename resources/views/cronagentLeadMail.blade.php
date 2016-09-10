<?php if(count($data)>=1){ ?>
<table border="1">
   <tr style="background-color:#F7A52D;color:#fff;">
        <th>#</th>
        <th>Seeker Name</th>
        <th>Seeker Email</th>
        <th>Seeker Phoneno</th>
        <th>City</th>
        <!--<th>Location</th>-->
        <th>Price</th>
        <th>Req Id</th>
        <th>Project Id</th>
        <th>Posted By</th>
        <th>Project Name</th>
        <th>Builder Name</th>
        <th>Call Disposition</th>
        <th>Campaign Type</th>
        <th>Primary Intent</th>
        <th>Email Sent</th>
        <th>SMS Sent</th>
        <th>Agent Name</th>
        <th>Agent Id</th>
   </tr>
    <?php
    $i=1;
    foreach($data as $cron){
        ?>
        <tr style="">
            <td><?php echo $i; ?></td>
            <td><?php echo $cron['seeker_name'];?></td>
            <td><?php echo $cron['seeker_email'];?></td>
            <td><?php echo $cron['seeker_phone'];?></td>
            
            <td><?php echo $cron['city_name'];?></td>
            <!--<td><?php //echo $cron['location'];?></td>-->
            <td><?php echo $cron['price'];?></td>
            
            <td><?php echo $cron['req_id'];?></td>
            <td><?php echo $cron['project_id'];?></td>
            <td><?php echo $cron['posted_by'];?></td>
            <td><?php echo $cron['project_name'];?></td>
            <td><?php echo $cron['builder_name'];?></td>
            <td><?php echo $cron['call_disposition'];?></td>
            <td><?php echo $cron['vl_status'];?></td>
            <td><?php echo $cron['primary_intent'];?></td>
            <td><?php echo $cron['email_sent'];?></td>
            <td><?php echo $cron['sms_sent'];?></td>
            <td><?php echo $cron['agent_name'];?></td>
             <td><?php echo $cron['agent_id'];?></td>
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
        <th>Seeker Name</th>
        <th>Seeker Email</th>
        <th>Seeker Phoneno</th>
        <th>City</th>
        <th>Location</th>
        <th>Price</th>
        <th>Req Id</th>
        <th>Project Id</th>
        <th>Posted By</th>
        <th>Project Name</th>
        <th>Builder Name</th>
        <th>Call Disposition</th>
        <th>Campaign Type</th>
        <th>Primary Intent</th>
        <th>Email Sent</th>
        <th>SMS Sent</th>
        <th>Agent Name</th>
        <th>Agent Id</th>
   </tr>
       <tr style="">
            <th colspan="12">No records Found</th>
       </tr>
    <?php
}
?>