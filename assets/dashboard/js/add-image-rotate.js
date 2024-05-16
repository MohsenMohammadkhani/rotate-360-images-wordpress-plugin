function checkForm(e) {
  e.preventDefault();
  const imagesIDS = document.querySelector("#images_ids").value;
  if (!imagesIDS) {
    return;
  }
  e.currentTarget.submit();
}

function removeItem(imageID) {
  document.querySelector(`#rota_images_selected .item-${imageID}`).remove();
  const imagesIDS = document.querySelector("#images_ids").value;
  let imagesIDSArray = imagesIDS.split(",");
  const index = imagesIDSArray.indexOf(imageID + "");
  if (index > -1) {
    imagesIDSArray.splice(index, 1);
  }
  document.querySelector("#images_ids").value = imagesIDSArray.toString();
}

jQuery(document).ready(function ($) {
  function addImageBox(image) {
    return `<div class="item item-${image.ID}">
                <div style="width: 100px;height: 100px">
                    <a target="_blank"
                       href="${image.src}">
                        <img style="width:100%;height: 100%"
                             src="${image.src}"/>
                    </a>
                </div>
                <div class="icon-remove" onclick="removeItem(${image.ID})"  >
                    <span class="dashicons dashicons-no"></span>
                </div>
            </div>`;
  }

  jQuery("input#rota_media_manager").click(function (e) {
    e.preventDefault();
    let image_frame;
    if (image_frame) {
      image_frame.open();
    }

    image_frame = wp.media({
      title: "Select Media",
      multiple: true,
      library: {
        type: "image",
      },
    });

    image_frame.on("select", function () {
      let imagesIDS = jQuery("#images_ids").val();
      const selection = image_frame.state().get("selection");
      const gallery_ids = new Array();
      let my_index = 0;
      selection.each(function (attachment) {
        const attachmentID = attachment["id"];
        if (imagesIDS.includes(attachmentID)) {
          alert("عکس شماره " + attachmentID + " از قبل انتخاب شده");
          return;
        }
        gallery_ids[my_index] = attachment["id"];
        my_index++;
      });
      const ids = gallery_ids.join(",");
      if (ids.length === 0) return true;
      if (imagesIDS != "") {
        imagesIDS = imagesIDS + ",";
      }
      jQuery("#images_ids").val(imagesIDS + ids);
      jQuery.get(
        ajaxurl,
        {
          action: "get_image_src_with_attachment_ID",
          images_IDS: ids.split(","),
        },
        function (response) {
          const imagesUrls = JSON.parse(response);
          imagesUrls.forEach(function (image) {
            jQuery("#rota_images_selected").append(addImageBox(image));
          });
        }
      );
    });
    image_frame.open();
  });
});
