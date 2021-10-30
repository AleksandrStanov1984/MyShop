<div class="remodal-overlay remodal-is-opened" style="display: block;" id="overlay-popup"></div>
<div class="remodal-wrapper remodal-is-opened" style="display: block;" id="wraper-popup">
<script type="text/javascript">
jQuery(document).ready(function() {
jQuery('#close-popup').click(function(){   
   document.getElementById('overlay-popup').remove(); 
   document.getElementById('wraper-popup').remove(); 
});
});

</script>


<div class="remodal modal-catalog remodal-is-initialized remodal-is-opened" data-remodal-id="modal-catalog<?php echo $category['category_id'] ?>" id="modal-catalog">
    <button data-remodal-action="close" class="remodal-close" id="close-popup"></button>
    <div class="modal-catalog-list">
        
        <div class="item">
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/dump.php' ); //for debug only
 obj_dump($first_real); 
 obj_dump($select_data); 
 ?>
 
        </div>
  
    
    </div>
</div>


</div>