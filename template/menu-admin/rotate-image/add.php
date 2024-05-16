<?php if (!defined('ABSPATH')) exit; ?>
<div id="rota-container">
    <form method="POST" onsubmit="return checkForm(event)">
        <br/>
        <div>
            <label>عنوان</label>
            <input type="text" name="title" required/>
        </div>
        <br/>
        <label>
            توجه داشته باشید که اندازه عرض و ارتفاع برای همه عکس ها باید برابر باشند
        </label>

        <br/>
        <div>
            <label>زمان تعویض عکس (میلی ثانیه)</label>
            <input type="number" name="speed" required/>
        </div>
        <br/>
        <div>
            <label>رنگ پس زمینه</label>
            <input type="color" name="color" required/>
        </div>
        <br/>
        <div>
            <label>رنگ پس زمینه دکمه ها</label>
            <input type="color" name="background-color-buttons" required/>
        </div>
        <br/>
        <div>
            <label>عکس
                (برای انتخاب چند عکس دکمه ctrl یا دکمه shift را گرفته و عکس ها را انتخاب کنید)
            </label>
            <span>
                    <input type="hidden" name="images_ids" id="images_ids"/>
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
        <div id="rota_images_selected"></div>
        <br/>
        <button type="submit" class="button-primary">درج</button>
        <input type="hidden" name="nonce"
               value="<?php echo esc_attr(wp_create_nonce('rota-add-rotate-image')); ?>"/>
    </form>
</div>