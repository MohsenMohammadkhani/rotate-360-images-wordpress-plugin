<?php if (!defined('ABSPATH')) exit; ?>
<div>
    <p>
        برای
        <a href="/wp-admin/admin.php?page=rota-menu-pages" target="_blank">
            نمایش چرخش ۳۶۰
        </a>
        درجه عکس زیر عکس محصول ابتدا چرخش ۳۶۰ خود را انتخاب کنید.
    </p>


    <div>

        <div>
            <?php
            if (count($allRotate) > 0) {
                ?>
                <select style="width: 100%" class="rota-rotate-360-images-id" name="rota-rotate-360-images-id">
                    <?php foreach ($allRotate as $key => $rotate) { ?>
                        <option
                            <?php
                            if ($rotate360ImageID) {
                                if ($rotate360ImageID == $rotate->id) {
                                    echo "selected='selected'";
                                }
                            }

                            ?>
                                value=<?php echo esc_attr($rotate->id); ?>>
                            <?php
                            echo esc_attr("$rotate->id-$rotate->title");
                            ?>
                        </option>
                    <?php } ?>
                </select>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function () {
        jQuery('.rota-rotate-360-images-id').select2();
    });
</script>