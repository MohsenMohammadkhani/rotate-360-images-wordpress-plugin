<?php if (!defined('ABSPATH')) exit; ?>
<div id="rota-container">
    <div class="rota-rotate-360-image-container wrap">
    </div>
</div>

<script type="text/javascript">
    let titleSearch;
    let IDSearch;
    let currentPage = 1;
    let loadFormSearch = 0
    let showUserDoseNotRotate360Image = 0

    function copyShortcodeToClipboard(rotateID) {
        navigator.clipboard.writeText(`[rota_rotate_360_images id="${rotateID}"]`);
        alert('شورتکد در کلیبورد شما کپی شد.')
    }

    function copyHtmlTagsToClipboard(rotateID) {
        navigator.clipboard.writeText(`
<div class="rota-rotate-360-image" id="rota-rotate-360-image-${rotateID}">
  <img class="images"  />
  <div class="preload-images"></div>
</div>`);
        alert('تگ html در کلیبورد شما کپی شد. ')
    }


    jQuery(document).ready(function () {
        getRotate360Images()
    });

    async function getRotate360Images() {
        rotaAddSpinnerLoader()
        await getRotate360ImagesResponse()
        rotaRemoveSpinnerLoader()
    }

    function removeRotates360Image() {
        jQuery(".rota-rotate-360-image-container div.pagination").remove();
        jQuery(".rota-rotate-360-image-container table").remove();
    }

    function rotaAddSpinnerLoader() {
        jQuery("body").append("<div class='rota-spinner-loader-container'><div class='rota-spinner-loader'></div></div>")
    }

    function rotaLoadKeyUpFormSearch() {
        if (loadFormSearch) {
            return
        }

        jQuery("#id-search").keyup(function (e) {
            IDSearch = e.target.value;
            currentPage = 1
            getRotate360Images()
        })

        jQuery("#title-search").keyup(function (e) {
            titleSearch = e.target.value;
            currentPage = 1
            getRotate360Images()
        })
        loadFormSearch = 1
    }

    function rotaShowFormSearch() {
        if (loadFormSearch) {
            return "";
        }
        return (`
 <a href="/wp-admin/admin.php?page=rota-menu-pages&action=add" class="button-primary">
            چرخش عکس جدید
        </a>
            <div class="rota-py-2">
                    <span>
                      شماره
                    </span>
                    <span>
                       <input type="number" id="id-search" />
                    </span>

                     <span>
                      عنوان
                    </span>
                    <span>
                       <input type="text" id="title-search" />
                    </span>
            </div>
        `)
    }

    function rotaRemoveSpinnerLoader() {
        jQuery(".rota-spinner-loader-container").remove();
    }

    function rotaShowUserDoseNotHaveRotate360Image() {
        if (showUserDoseNotRotate360Image) {
            return;
        }
        jQuery(".rota-rotate-360-image-container").append(
            `
                  <div id="message" class="notice notice-success ">
            <p>
                شما چرخش عکس جدید ندارید.
                یک
                <a target="_blank"
                   href="/wp-admin/admin.php?page=rota-menu-pages&action=add">
                    چرخش عکس جدید اضافه کنید
                </a>
            </p>
        </div>
                `
        );
        showUserDoseNotRotate360Image = 1
    }

    async function getRotate360ImagesResponse(page) {
        await jQuery.get(ajaxurl,
            {
                'action': 'get_rotate_360_image',
                'page': currentPage,
                'title': titleSearch,
                'id': IDSearch,
            }, function (response) {
                removeRotates360Image()
                if (!response['count-page']) {
                    rotaShowUserDoseNotHaveRotate360Image()
                    return;
                }

                jQuery(".rota-rotate-360-image-container #message").remove();
                jQuery(".rota-rotate-360-image-container").append(generateTable(response['rotate-360-Image']));
                jQuery(".rota-rotate-360-image-container").append(
                    `
                    <div class="pagination">
                        ${rotaMakePagination(
                        response['count-page'],
                        currentPage,
                        (pageNumberClick) => {
                            currentPage = pageNumberClick
                            getRotate360Images()
                        }
                    )
                    }
                    </div>
                    `)
                rotaLoadKeyUpFormSearch()
            });
    }

    function generateHeadTable() {
        return (
            `<thead>
            <tr>
                <td class="text-center">
                    <b>
                        ردیف
                    </b>
                </td>

                <td class="text-center">
                    <b>
                        شماره
                    </b>
                </td>

                <td class="text-center">
                    <b>
                        عنوان
                    </b>
                </td>

                <td class="text-center">
                    <b>کپی شورتکد
                    </b>
                </td>

                <td class="text-center">
                    <b>کپی تگ html </b>
                </td>

                <td class="text-center">
                    <b>فعال
                    </b>
                </td>

                <td class="text-center">
                    <b>عملیات
                    </b>
                </td>
            </tr>
            </thead>`
        )
    }

    function generateTable(rotates360Image) {
        return (
            `
            ${rotaShowFormSearch()}
<table class="wp-list-table widefat fixed striped table-view-list" id="rota-rotate-360-image-table">
                 ${generateHeadTable()}<tbody>${generateBodyTable(rotates360Image)}</tbody>
            </table>`
        )

    }

    function generateBodyTable(rotates360Image) {
        return rotates360Image.map((item, index) => {
            index = index + 1
            return (`<tr>
                <td class="text-center"> ${index}</td>
            <td class="text-center">${item.id}</td>
            <td class="text-center">${item.title}</td>
            <td class="text-center">
                            <span onclick="copyShortcodeToClipboard(${item.id})"
                                  class="button-primary rota-shortcode-copy-icon">
                            <span class="dashicons dashicons-admin-page"></span>
                            </span>
            </td>
            <td class="text-center">
                            <span onclick="copyHtmlTagsToClipboard(${item.id})"
                                  class="button-primary rota-tag-copy-icon">
                            <span class="dashicons dashicons-admin-page"></span>
                            </span>
            </td>
            <td class="text-center">${parseInt(item['active']) ? " فعال" : "غیرفعال"}</td>
            <td class="text-center">
                <div class="text-center">
                            <span>
                                  <a class="text-decoration-none "
                                     href="/wp-admin/admin.php?page=rota-menu-pages&action=edit&id=${item.id}">
                                        <span class="dashicons dashicons-edit"></span>
                                  </a>
                            </span>
                    <span>
                                     <a class="text-decoration-none "
                                        href="/wp-admin/admin.php?page=rota-menu-pages&action=remove&id=${item.id}">
                                         <span class="dashicons dashicons-trash"></span>
                                     </a>
                            </span>
                    <span>
                   <a class="text-decoration-none "
                      href="/wp-admin/admin.php?page=rota-menu-pages&action=toggle-status&id=${item['id']}">
                 <span class="dashicons dashicons-${parseInt(item['active']) ? 'controls-pause' : 'controls-play'}" ></span>
            </a>
                            </span>

                </div>
            </td>
        </tr>`);
        }).join('');
    }
</script>
