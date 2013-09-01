

<?php
 if (isset($_SERVER['HTTP_USER_AGENT']) && 
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) $ie = true; else $ie=false;
  ?>
		
<script type="text/javascript">
function activate_paperfold(){
$('.pf').paperfold({
					duration : 700,
					CSSAnimation : false,
					useOriginal : true
				});	
}
</script>
<?php if(isset($this->content_paperfold))
					echo '<div id="close_all"><a href="#" onClick="return false;" >'.$this->Html->image("close_all.png").'</a></div>';
?>					
<div class="pf">
		<div class="pf__item pf__item_collapsed">
			<div class="pf__short">
				<div class="pf__reducer">
					<!-- Short content -->
				</div>
			</div>

			<div class="pf__trigger pf__trigger_collapsed">
				<span class="pf__trigger-text pf__trigger-text_collapsed">Expand &rarr;</span>
				<span class="pf__trigger-text pf__trigger-text_expanded">&larr; Collapse</span>
			</div>

				<div class="pf__full">
					<div class="pf__reducer">
					<?php if(isset($this->content_paperfold))
					echo  '<div id="extra_thumbs">'.$this->content_paperfold.'</div>';	?>
					</div>
				</div>
			</div>

			
		</div>