<?php
/**
 * Image Storage Application Interface
 */
?>
<div class="orbis-app-images">
    <div class="orbis-app-toolbar">
        <button id="orbis-upload-image-btn" class="button button-primary"><?php echo orbis_t('upload_image', 'Upload Image', 'رفع صورة', 'Images'); ?></button>
    </div>

    <div class="orbis-gallery-container">
        <div id="orbis-gallery-grid" class="orbis-gallery-grid">
            <!-- Loaded via AJAX or WP Query -->
            <?php
            $query_images = new WP_Query( array(
                'post_type'      => 'attachment',
                'post_mime_type' => 'image',
                'post_status'    => 'inherit',
                'posts_per_page' => 20,
                'author'         => get_current_user_id()
            ) );

            if ( $query_images->have_posts() ) :
                while ( $query_images->have_posts() ) : $query_images->the_post();
                    $url = wp_get_attachment_thumb_url( get_the_ID() );
                    echo '<div class="orbis-image-tile"><img src="' . esc_url($url) . '"></div>';
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>' . orbis_t('no_images', 'No images uploaded yet.', 'لم يتم رفع صور بعد.', 'Images') . '</p>';
            endif;
            ?>
        </div>
    </div>
</div>

<style>
.orbis-gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px; margin-top: 20px; }
.orbis-image-tile { background: #fff; padding: 5px; border-radius: 8px; border: 1px solid #eee; overflow: hidden; height: 150px; }
.orbis-image-tile img { width: 100%; height: 100%; object-fit: cover; border-radius: 5px; }
</style>
