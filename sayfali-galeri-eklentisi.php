<?php
/*
Plugin Name: Sayfalı Galeri Eklentisi
Plugin URI: http://devorion.work
Description: Sayfalı Galeri Eklentisi
Author: Selman Demirdoven
Version: 1.0.0
Author URI: http://devorion.work
*/

if ( !defined( 'ABSPATH' ) ){
	exit;
}
if ( ! defined( 'OFFERS_PLG_DIR' ) ) {
	define( 'OFFERS_PLG_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'OFFERS_PLG_URL' ) ) {
	define( 'OFFERS_PLG_URL', plugin_dir_url( __FILE__ ) );
}
function wptuts_add_color_picker($hook){
	
	global $post;
	
    	if( in_array($hook, array('post.php', 'post-new.php') ) ){
	        $screen = get_current_screen();
	        if( is_object( $screen ) && 'post' == $screen->post_type ){
			wp_enqueue_style( 'wp-color-picker' ); 
			wp_enqueue_script( 'custom-script-handle', OFFERS_PLG_URL.'/assets/js/custom_admin.js', array( 'jquery', 'wp-color-picker' ), '1.0', true ); 
		}
	}
}
add_action( 'admin_enqueue_scripts', 'wptuts_add_color_picker' );

function add_gallery_img_func(){
	add_meta_box(
		'post_gallery2',
		'Galeri Ayarları',
		'galeri_ayarlari_callback',
		'post',
		'normal',
		'core'
	);
}
add_action( 'admin_init', 'add_gallery_img_func' );

function galeri_ayarlari_callback(){
	wp_nonce_field( basename(__FILE__), 'sample_nonce' );
	global $post;
	$metas = get_post_meta( $post->ID );
	$gallery_data = get_post_meta( $post->ID, 'gallery_data', true );
	?>
	<style>
	li.tek_secenek {
	    display: flex;
	    justify-content: space-between;
	    align-items: flex-start;
	    padding: 1.4em 0;
	    border-bottom: 1px solid #dbdbdb;
	}
	ul.galeri_ayarlari_list li:last-child {
	    border-bottom: 0;
	}
	.secenek_left {
	    width: 20%;
	}
	.secenek_right {
	    width: 75%;
	}
	.secenek_left span {
	    font-weight: bold;
	}
	.secenek_desc {
	    margin-top: 10px;
	}
	.secenek_options label {
	    display: block;
	    margin-bottom: 5px;
	}
	.secenek_options textarea {
	    width: 100%;
	    display: block;
	    height: 100px;
	}
	</style>
	<ul class="galeri_ayarlari_list">
		<li class="tek_secenek">
			<div class="secenek_left">
				<span>Sayfalama</span>
			</div>
			<div class="secenek_right">
				<div class="secenek_options">
					<select name="sayfalama_durum">
						<option value="acik" <?php selected($metas['sayfalama_durum'][0], 'acik'); ?>>Açık</option>
						<option value="kapali" <?php selected($metas['sayfalama_durum'][0], 'kapali'); ?>>Kapalı</option>
					</select>
				</div>
				<div class="secenek_desc">Sayfalamanın görünüp görünmeyeceğini seçiniz</div>
			</div>
		</li>
		<li class="tek_secenek">
			<div class="secenek_left">
				<span>Sayfalama Rengi</span>
			</div>
			<div class="secenek_right">
				<div class="secenek_options">
					<ul>
						<li>
							<div>Arkaplan</div>
							<div><input type="text" class="color-field" name="sayfalama_bg_rengi" value="<?php if( $metas['sayfalama_bg_rengi'] ){ echo $metas['sayfalama_bg_rengi'][0]; } ?>"/></div>
						</li>
						<li>
							<div>Metin</div>
							<div><input type="text" class="color-field" name="sayfalama_text_rengi" value="<?php if( $metas['sayfalama_text_rengi'] ){ echo $metas['sayfalama_text_rengi'][0]; } ?>"/></div>
						</li>
						<li>
							<div>Hover Arkaplan</div>
							<div><input type="text" class="color-field" name="sayfalama_hover_bg_rengi" value="<?php if( $metas['sayfalama_hover_bg_rengi'] ){ echo $metas['sayfalama_hover_bg_rengi'][0]; } ?>"/></div>
						</li>
						<li>
							<div>Hover Metin</div>
							<div><input type="text" class="color-field" name="sayfalama_hover_text_rengi" value="<?php if( $metas['sayfalama_hover_text_rengi'] ){ echo $metas['sayfalama_hover_text_rengi'][0]; } ?>"/></div>
						</li>
						
					</ul>	
				</div>
				<div class="secenek_desc">Galeri sayfalama rengini seçiniz (opsiyonel)</div>
			</div>
		</li>
		
		<li class="tek_secenek">
			<div class="secenek_left">
				<span>Alt Başlık ve Açıklama</span>
			</div>
			<div class="secenek_right">
				<div class="secenek_options">
					<label>
						<input type="radio" name="alt_baslik_ve_aciklama" value="olsun" <?php checked($metas['alt_baslik_ve_aciklama'][0], 'olsun'); ?>/>
						<span>Olsun</span>
					</label>
					<label>
						<input type="radio" name="alt_baslik_ve_aciklama" value="olmasin" <?php checked($metas['alt_baslik_ve_aciklama'][0], 'olmasin'); ?>/>
						<span>Olmasın</span>
					</label>
					
				</div>
				<div class="secenek_desc">Alt başlık ve açıklama olup olmayacağını seçiniz</div>
			</div>
		</li>
		
		<li class="tek_secenek">
			<div class="secenek_left">
				<span>Ara Reklam</span>
			</div>
			<div class="secenek_right">
				<div class="secenek_options">
					<select name="ara_reklam_durum">
						<option value="kapali" <?php selected($metas['ara_reklam_durum'][0], 'kapali'); ?>>Kapalı</option>
						<option value="acik" <?php selected($metas['ara_reklam_durum'][0], 'acik'); ?>>Açık</option>
					</select>
				</div>
				<div class="secenek_desc">Ara reklamın görünüp görünmeyeceğini seçiniz</div>
			</div>
		</li>
		<li class="tek_secenek">
			<div class="secenek_left">
				<span>Ara Reklam Kodu</span>
			</div>
			<div class="secenek_right">
				<div class="secenek_options">
					<textarea name="ara_reklam_kodu"><?php if($metas['ara_reklam_kodu']){ echo htmlspecialchars_decode($metas['ara_reklam_kodu'][0]); } ?></textarea>
				</div>
				<div class="secenek_desc">Araya gelecek reklam kodunu giriniz (opsiyonel)</div>
			</div>
		</li>
		
		<li class="tek_secenek">
			<div class="secenek_left">
				<span>Ara Reklam Sırası</span>
			</div>
			<div class="secenek_right">
				<div class="secenek_options">
					<select name="ara_reklam_sirasi">
						<?php
						for($i=1; $i<51; $i++){
							?>
							<option value="<?php echo $i; ?>" <?php selected($metas['ara_reklam_sirasi'][0], $i); ?>><?php echo $i; ?></option>
							<?php
						}
						?>
					</select>
				</div>
				<div class="secenek_desc">Ara reklamın kaçıncı sırada görüneceğini seçiniz</div>
			</div>
		</li>
		
		<li class="tek_secenek">
			<div class="secenek_left">
				<span>İleri-Geri Oklar</span>
			</div>
			<div class="secenek_right">
				<div class="secenek_options">
					<select name="oklar_durum">
						<option value="acik" <?php selected($metas['oklar_durum'][0], 'acik'); ?>>Açık</option>
						<option value="kapali" <?php selected($metas['oklar_durum'][0], 'kapali'); ?>>Kapalı</option>
					</select>
				</div>
				<div class="secenek_desc">Okların görünüp görünmeyeceğini seçiniz</div>
			</div>
		</li>
		<li class="tek_secenek">
			<div class="secenek_left">
				<span>Görsel Sıra Numarası</span>
			</div>
			<div class="secenek_right">
				<div class="secenek_options">
					<select name="sira_bilgi_durum">
						<option value="acik" <?php selected($metas['sira_bilgi_durum'][0], 'acik'); ?>>Açık</option>
						<option value="kapali" <?php selected($metas['sira_bilgi_durum'][0], 'kapali'); ?>>Kapalı</option>
					</select>
				</div>
				<div class="secenek_desc">Görsel sıra numarasının görünüp görünmeyeceğini seçiniz</div>
			</div>
		</li>
		
	</ul>
	<?php
}

function orion_gallery_save_cb( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ 'sample_nonce' ] ) && wp_verify_nonce( $_POST[ 'sample_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
		
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( 'post' != $_POST['post_type'] ){
			return;
		}
		
		if ( isset($_POST['sayfalama_durum']) ){
			update_post_meta( $post_id, 'sayfalama_durum', $_POST['sayfalama_durum'] );
		}
		if ( isset($_POST['sayfalama_bg_rengi']) ){
			update_post_meta( $post_id, 'sayfalama_bg_rengi', $_POST['sayfalama_bg_rengi'] );
		}
		if ( isset($_POST['sayfalama_text_rengi']) ){
			update_post_meta( $post_id, 'sayfalama_text_rengi', $_POST['sayfalama_text_rengi'] );
		}
		if ( isset($_POST['sayfalama_hover_bg_rengi']) ){
			update_post_meta( $post_id, 'sayfalama_hover_bg_rengi', $_POST['sayfalama_hover_bg_rengi'] );
		}
		if ( isset($_POST['sayfalama_hover_text_rengi']) ){
			update_post_meta( $post_id, 'sayfalama_hover_text_rengi', $_POST['sayfalama_hover_text_rengi'] );
		}
	
		if ( isset($_POST['alt_baslik_ve_aciklama']) ){
			update_post_meta( $post_id, 'alt_baslik_ve_aciklama', $_POST['alt_baslik_ve_aciklama'] );
		}
		if ( isset($_POST['ara_reklam_durum']) ){
			update_post_meta( $post_id, 'ara_reklam_durum', $_POST['ara_reklam_durum'] );
		}
		if ( isset($_POST['oklar_durum']) ){
			update_post_meta( $post_id, 'oklar_durum', $_POST['oklar_durum'] );
		}
		if ( isset($_POST['sira_bilgi_durum']) ){
			update_post_meta( $post_id, 'sira_bilgi_durum', $_POST['sira_bilgi_durum'] );
		}
		
		if ( isset($_POST['ara_reklam_kodu']) ){
			update_post_meta( $post_id, 'ara_reklam_kodu', htmlspecialchars($_POST['ara_reklam_kodu']) );
		}
		if ( isset($_POST['ara_reklam_sirasi']) ){
			update_post_meta( $post_id, 'ara_reklam_sirasi', $_POST['ara_reklam_sirasi'] );
		}
}
add_action( 'save_post', 'orion_gallery_save_cb' );

function change_single_content($content){
    global $post;
	
    if ( 'post' == get_post_type() && is_single() ){
		if( get_query_var('oimage') ){
			$content = '[galeriye_gecelim]';
		}else{
			return $content.'<input type="hidden" name="postid" value="'.$post->ID.'"/>';
		}
    }
    return $content;
}
add_filter( 'the_content', 'change_single_content' );

function get_gallery_attids(){
	global $post;
	$post = get_post( $post );
	if ( get_post_gallery($post) ) :
		$gallery = get_post_gallery( get_the_ID(), false );
		$gallery_attachment_ids = explode( ',', $gallery['ids'] );
		return $gallery_attachment_ids;
	endif;
}

function add_footer_ect(){
	?>
	<script>
	(function($) {
		if( $('.gallery').eq(0).find('.gallery-item').length > 0 ){
			$('.gallery').eq(0).find('.gallery-item a').attr('rel', 'nofollow');
			var ajaxUrl = '<?php echo admin_url( "admin-ajax.php" ); ?>';
			var postid = $('input[name="postid"]').val();
			var data = {
				action: 'get_gallery_sanitize_titles',
				postid: postid
			}
			$.post( ajaxUrl, data, function(response){
				var res = JSON.parse(response);
				console.log(res);
				$('.gallery').eq(0).find('.gallery-item').find('a').removeClass('ilightbox-gallery');
				
				$('.gallery').eq(0).find('.gallery-item').each(function(ind){
					$('.gallery').eq(0).find('.gallery-item').eq(ind).find('a').attr('href', res[ind]+'#main-content');
				});
			});
		}
	})(jQuery)
	</script>
	<?php
}
add_action('wp_footer', 'add_footer_ect');

function get_gallery_sanitize_titles(){
	$postid = $_REQUEST['postid'];
	if ( get_post_gallery($postid) ) :
		$gallery = get_post_gallery( $postid, false );
		$gallery_attachment_ids = explode( ',', $gallery['ids'] );
		$ids = $gallery_attachment_ids;
	endif;
	$titles = array();
	foreach($ids as $id){
		$titles[] = sanitize_title(get_the_title($id));
	}
	echo json_encode($titles);
	wp_die();
}
add_action('wp_ajax_get_gallery_sanitize_titles', 'get_gallery_sanitize_titles');
add_action('wp_ajax_nopriv_get_gallery_sanitize_titles', 'get_gallery_sanitize_titles');


function galeriye_gecelim( $atts ){	
	ob_start();
	global $post;
	
	$metas = get_post_meta( $post->ID );
?>
<style>
nav#crumbs,
h1.name.post-title.entry-title,
p.post-meta {
    display: none;
}
.ogallery_head {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.reklam_wrap {
    margin: 1em 0;
}
.ogallery_body {
    margin-top: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.ogallery_body a {
    display: block;
    text-align: center;
}
.ogallery_footer {
	<?php
	if($metas['sayfalama_durum'] && $metas['sayfalama_durum'][0]=='kapali'){
		echo 'display: none;';
	}else{
		echo 'display: flex;';
	}
	?>
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 1em;
}
.ogallery_footer > a {
    background: <?php if($metas['sayfalama_bg_rengi'] && $metas['sayfalama_bg_rengi'][0]!=''){echo $metas['sayfalama_bg_rengi'][0];}else{echo '#ececec';} ?>;
    color: <?php if($metas['sayfalama_text_rengi'] && $metas['sayfalama_text_rengi'][0]!=''){echo $metas['sayfalama_text_rengi'][0];}else{echo '#979797';} ?>;
    margin: 2px;
    padding: 8px;
    line-height: 10px;
    border-radius: 3px;
    font-size: 14px;
	text-decoration: none!important;
}
.ogallery_footer > a.act,
.ogallery_footer > a:hover {
    background: <?php if($metas['sayfalama_hover_bg_rengi'] && $metas['sayfalama_hover_bg_rengi'][0]!=''){echo $metas['sayfalama_hover_bg_rengi'][0];}else{echo '#4a4a4a';} ?>;
    color: <?php if($metas['sayfalama_hover_text_rengi'] && $metas['sayfalama_hover_text_rengi'][0]!=''){echo $metas['sayfalama_hover_text_rengi'][0];}else{echo '#fff';} ?>;
    text-decoration: none!important;
}
a.onceki_btn,
a.sonraki_btn {
    background: #d5d5d5;
    color: #333;
    line-height: 1;
    padding: 8px 14px;
    border-radius: 3px;
	text-decoration: none!important;
	<?php
	if($metas['oklar_durum'] && $metas['oklar_durum'][0]=='kapali'){
		echo 'display: none;';
		
	}
	?>
}
a.onceki_btn:hover,
a.sonraki_btn:hover {
	background: #4a4a4a;
    color: #fff;
	text-decoration: none!important;
}
a.onceki_btn.ilk,
a.sonraki_btn.son {
    opacity: .3;
}
.ogallery_head span {
	margin: 0 auto;
}
.ogallery_body img {
    text-align: center;
    margin: 0 auto;
}
.galeri_breadcrumb {
    margin: 1em 0;
    text-align: center;
}
.galeri_breadcrumb span {
    font-size: 11px;
}
.content_wrap {
    margin: 0 auto;
}
</style>
<?php
	$arstatus = get_post_meta($post->ID, 'ara_reklam_durum', true);
	$gallery_data = get_post_meta( $post->ID, 'gallery_data', true );
	if ( get_post_gallery($postid) ) :
		$gallery = get_post_gallery( $postid, false );
		$gallery_attachment_ids = explode( ',', $gallery['ids'] );
		$ids = $gallery_attachment_ids;
	endif;
	$slug_list = array();
	foreach($ids as $id){
		$slug_list[] = sanitize_title(get_the_title($id));
	}
	$get_var = get_query_var('oimage');
	if( $arstatus && $arstatus=='acik' ){
		$ara_reklam_sirasi = get_post_meta($post->ID, 'ara_reklam_sirasi', true);
		$ara_reklam_ind = (int)$ara_reklam_sirasi-1;
		array_splice( $slug_list, $ara_reklam_ind, 0, 'reklam' );
		array_splice( $ids, $ara_reklam_ind, 0, 'rerere' );
	}
	$current_index = array_search($get_var, $slug_list);
	$onceki_url = get_permalink($post->ID).$slug_list[$current_index-1];
	$sonraki_url = get_permalink($post->ID).$slug_list[$current_index+1];
		
	if( $get_var == 'reklam' ){
		$title = 'Reklam';
		$ara_reklam_kodu = $metas['ara_reklam_kodu'][0];
		$content = htmlspecialchars_decode($ara_reklam_kodu);
	}else{
		$title = get_the_title($ids[$current_index]);
		$img_src = wp_get_attachment_image_src($ids[$current_index], 'full');
		$content = '<div class="content_wrap"><a><img src="'.esc_url($img_src[0]).'"/></a></div>';	
	}
	$abva = $metas['alt_baslik_ve_aciklama'][0];
	if($abva && $abva=='olsun'){ ?><h2 style="text-align: center;"><?php echo $title; ?></h2><?php }
	?>
	<div class="galeri_breadcrumb"><span><a class="crumbs-home" href="<?php echo get_site_url(); ?>">Anasayfa</a></span> <span class="delimiter">»</span> <span><a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_title($post->ID); ?></a></span> <span class="delimiter">»</span> <span class="current"><?php echo $title; ?></span></div>
	<div class="ogallery_head">
		<a href="<?php echo $onceki_url; ?>#main-content" class="onceki_btn <?php if(($current_index+1)==1){echo 'ilk';} ?>">Önceki</a>	
		<?php $sbd = $metas['sira_bilgi_durum'][0];
		if( $sbd && $sbd=='kapali'){}else{ ?><span>Fotoğraf: <?php echo ($current_index+1).' / '.count($slug_list); ?></span><?php } ?>
		<a href="<?php echo $sonraki_url; ?>#main-content" class="sonraki_btn <?php if(($current_index+1)==count($slug_list)){echo 'son';} ?>">Sonraki</a>
	</div>
	<?php if( get_option('ust_reklam_durum') && get_option('ust_reklam_durum')==1 ){ reklam_getir('ust_reklam_kodu'); } ?>
	<div class="ogallery_body">
		<?php if( get_option('sol_reklam_durum') && get_option('sol_reklam_durum')==1 ){ reklam_getir('sol_reklam_kodu'); } ?>
		<?php echo $content; ?>
		<?php if( get_option('sag_reklam_durum') && get_option('sag_reklam_durum')==1 ){ reklam_getir('sag_reklam_kodu'); } ?>
	</div>
	<?php if( get_option('alt_reklam_durum') && get_option('alt_reklam_durum')==1 ){ reklam_getir('alt_reklam_kodu'); } ?>
	<div class="ogallery_footer">
		<?php for( $x=0; $x<count($slug_list); $x++ ){ if($current_index==$x){ $class='act'; }else{ $class=''; } echo '<a class="'.esc_attr($class).'" href="'.get_permalink($post->ID).$slug_list[$x].'#main-content">'.($x+1).'</a>'; } ?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'galeriye_gecelim', 'galeriye_gecelim' );

function reklam_getir($field){
	$reklam_code = get_option($field);
	if($reklam_code && $reklam_code!=''){
		echo '<div class="reklam_wrap">'.htmlspecialchars_decode($reklam_code).'</div>';
	}
}
function rewriteurl() {
	global
	$wp, $wp_rewrite;
	add_rewrite_tag('%oimage%', '([^&]+)', 'oimage=');
	$wp->add_query_var('oimage');
	add_rewrite_rule('^kategori/([^/]+)/?$', 'index.php?category_name=$matches[1]', 'top');
	add_rewrite_rule('^kategori/([^/]+)/([^/]+)/?$', 'index.php?category_name=$matches[2]', 'top');
	add_rewrite_rule('^kategori/([^/]+)/page/([^/]+)/?$', 'index.php?category_name=$matches[1]&paged=$matches[2]', 'top');
	add_rewrite_rule('^etiket/([^/]+)/?$', 'index.php?tag=$matches[1]', 'top');
	add_rewrite_rule('([^/]+)/([^&]+)', 'index.php?name=$matches[1]&oimage=$matches[2]', 'top');
	$wp_rewrite->flush_rules(true);
}
add_action('init', 'rewriteurl');

function orion_bhs2_admin_page() {
	add_menu_page( 'Reklam Ayarları', 'Reklam Ayarları', 'manage_options', 'reklam_settings', 'reklam_settings_cb' , 'dashicons-slides');
}
add_action( 'admin_menu', 'orion_bhs2_admin_page' );

function reklam_settings_cb(){
	
	if( isset($_POST['kaydett']) ){
		
		if( isset($_POST['alt_reklam_kodu']) && !empty($_POST['alt_reklam_kodu']) ){
			update_option('alt_reklam_kodu', htmlspecialchars(stripslashes($_POST['alt_reklam_kodu'])));
		}
		if( isset($_POST['ust_reklam_kodu']) && !empty($_POST['ust_reklam_kodu']) ){
			update_option('ust_reklam_kodu', htmlspecialchars(stripslashes($_POST['ust_reklam_kodu'])));
		}
		if( isset($_POST['sol_reklam_kodu']) && !empty($_POST['sol_reklam_kodu']) ){
			update_option('sol_reklam_kodu', htmlspecialchars(stripslashes($_POST['sol_reklam_kodu'])));
		}
		if( isset($_POST['sag_reklam_kodu']) && !empty($_POST['sag_reklam_kodu']) ){
			update_option('sag_reklam_kodu', htmlspecialchars(stripslashes($_POST['sag_reklam_kodu'])));
		}
		
		if( isset($_POST['ust_reklam_durum']) ){
			update_option('ust_reklam_durum', 1);
		}else{
			delete_option('ust_reklam_durum');
		}
		if( isset($_POST['alt_reklam_durum']) ){
			update_option('alt_reklam_durum', 1);
		}else{
			delete_option('alt_reklam_durum');
		}
		if( isset($_POST['sol_reklam_durum']) ){
			update_option('sol_reklam_durum', 1);
		}else{
			delete_option('sol_reklam_durum');
		}
		if( isset($_POST['sag_reklam_durum']) ){
			update_option('sag_reklam_durum', 1);
		}else{
			delete_option('sag_reklam_durum');
		}
		
	}

	?>
	<style>
	table.students_list td {
		padding: 10px 20px;
		background: #d9d9d9;
	}
	table.students_list td label {
		display: block;
		margin-bottom: 5px;
	}
	table.students_list tbody tr td textarea {
		width: 500px;
		height: 150px;
	}
	</style>
	<div class="wrap">
		<h1>Reklam Ayarları</h1>
		<br>
		<form action="" name="ayar_kaydett" method="post" class="">
			<table class="students_list">
				<tr>
					<td>Üst Reklam Kodu</td>
					<td><label><input type="checkbox" name="ust_reklam_durum" value="1" <?php checked(get_option('ust_reklam_durum'), 1); ?>/> Aktif</label><textarea name="ust_reklam_kodu"><?php if(get_option('ust_reklam_kodu')){ echo htmlspecialchars_decode(get_option('ust_reklam_kodu')); } ?></textarea></td>
				</tr>
				<tr>
					<td>Alt Reklam Kodu</td>
					<td><label><input type="checkbox" name="alt_reklam_durum" value="1" <?php checked(get_option('alt_reklam_durum'), 1); ?>/> Aktif</label><textarea name="alt_reklam_kodu"><?php if(get_option('alt_reklam_kodu')){ echo htmlspecialchars_decode(get_option('alt_reklam_kodu')); } ?></textarea></td>
				</tr>
				<tr>
					<td>Sol Reklam Kodu</td>
					<td><label><input type="checkbox" name="sol_reklam_durum" value="1" <?php checked(get_option('sol_reklam_durum'), 1); ?>/> Aktif</label><textarea name="sol_reklam_kodu"><?php if(get_option('sol_reklam_kodu')){ echo htmlspecialchars_decode(get_option('sol_reklam_kodu')); } ?></textarea></td>
				</tr>
				<tr>
					<td>Sağ Reklam Kodu</td>
					<td><label><input type="checkbox" name="sag_reklam_durum" value="1" <?php checked(get_option('sag_reklam_durum'), 1); ?>/> Aktif</label><textarea name="sag_reklam_kodu"><?php if(get_option('sag_reklam_kodu')){ echo htmlspecialchars_decode(get_option('sag_reklam_kodu')); } ?></textarea></td>
				</tr>
				
			</table>
			<br>
			<input type="submit" class="button button-primary" name="kaydett" value="Kaydet"/>
		</form>
	</div>
	<?php
}

function has_gallery($post_id = false) {
    if (!$post_id) {
        global $post;
    } else {
        $post = get_post($post_id);
    }
    return ( strpos($post->post_content,'[gallery') !== false); 
}

function orion_no_follow(){
    if('post'==get_post_type() && is_single()){
		if( get_query_var('oimage') ){
			echo "<meta name='robots' content='max-image-preview:large' />\n";
		}else{echo "<meta name='robots' content='noimageindex'/>\n";}
	}
}
add_action('wp_head', 'orion_no_follow', 1);

?>
