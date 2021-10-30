<div class="panel panel-default ulogin_panel" style="margin-top: 39px;">
    <div class="panel-heading"><?php echo $heading_title; ?></div>
    <div class="ulogin_panel-body">
    <div class='btn-soc btn-vk' id='activate_google'>
        <img src="catalog/view/theme/OPC080193_6/stylesheet/extension/icon_enter_gmail.svg" alt="gmail">
    </div>
    <div class='btn-soc btn-facebook'  id='activate_fb'>
      <img src="catalog/view/theme/OPC080193_6/stylesheet/extension/icon_enter_facebook.svg" alt="gmail">
    </div>

</div>
    <?php echo $ulogin_form; ?>
</div>

<script type="text/javascript">

    function is_touch_device(){
        if ("ontouchstart" in document.documentElement){
            return 1;
        }
        return 0;
    }

    $(document).ready(function(){


        $(document).delegate("#activate_fb",'click', function(){
            if(is_touch_device()){
                uLogin.startAuth('facebook', "", 0);
            }else{
                $(".ulogin-button-facebook").trigger('click');
            }
        });


           $(document).delegate("#activate_google",'click', function(){
            if(is_touch_device()){
                 uLogin.startAuth('google', "", 0);
            }else{
                 $(".ulogin-button-google").trigger('click');
            }
        });

    });
</script>
