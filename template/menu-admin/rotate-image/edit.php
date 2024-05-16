<?php if (!defined('ABSPATH')) exit; ?>
<div id="rota-container">
    <div>
        <form method="POST" onsubmit="return checkForm(event)">
            <br/>
            <div>
                <label>عنوان</label>
                <input type="text" name="title" value="<?php echo esc_attr($rotate->title) ?>" required/>
            </div>
            <br/>
            <div>
                <label>زمان تعویض عکس (میلی ثانیه)</label>
                <input type="number" name="speed" value="<?php echo esc_attr($rotate->speed) ?>" required/>
            </div>
            <br/>
            <div>
                <label>رنگ پس زمینه</label>
                <input type="color" name="color" value="#<?php echo esc_attr($rotate->background_color) ?>" required/>
            </div>
            <div>
                <label>رنگ پس زمینه دکمه ها</label>
                <input type="color" name="background-color-buttons"
                       value="#<?php echo esc_attr($rotate->background_color_button) ?>"
                       required/>
            </div>
            <br/>
            <label>
                توجه داشته باشید که اندازه عرض و ارتفاع برای همه عکس ها باید برابر باشند
            </label>
            <div>
                <label>عکس
                    (برای انتخاب چند عکس دکمه ctrl یا دکمه shift را گرفته و عکس ها را انتخاب کنید)
                </label>
                <span>
                    <input type="hidden" name="images_ids" id="images_ids"
                           value="<?php
                           $imagesIDSString = "";
                           foreach ($imagesRotate as $key => $imageRotate) {
                               $imagesIDSString .= $imageRotate->image_id . ",";
                           }
                           echo esc_attr(substr($imagesIDSString, 0, -1));
                           ?>"
                    />
                    <input type='button' class="button-primary"
                           value="<?php esc_attr_e('انتخاب عکس ها', 'mytextdomain'); ?>"
                           id="rota_media_manager"/>
            </span>
            </div>
            <span>
            <b>
                پیش نمایش عکس های انتخاب شده
            </b>
        </span>
            <br/>
            <div id="rota_images_selected">
                <?php
                foreach ($imagesRotate as $key => $imageRotate) {
                    $attachment = wp_get_attachment_image_src($imageRotate->image_id, 'full');
                    ?>
                    <div class="item item-<?php echo esc_attr($imageRotate->image_id); ?>">
                        <div style="width: 100px;height: 100px">
                            <a target="_blank"
                               href="<?php echo esc_url($attachment[0]); ?>">
                                <img style="width:100%;height: 100%"
                                     src="<?php echo esc_url($attachment[0]); ?>"/>
                            </a>
                        </div>
                        <div class="icon-remove" onclick="removeItem(<?php echo esc_attr($imageRotate->image_id); ?>)">
                            <span class="dashicons dashicons-no"></span>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <br/>
            <button type="submit" class="button-primary">ویرایش</button>
            <input type="hidden" name="nonce"
                   value="<?php echo esc_attr(wp_create_nonce('rota-edit-rotate-image')); ?>"/>
        </form>
    </div>
</div>