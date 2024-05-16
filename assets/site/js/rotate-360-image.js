let intervalAutoRotateObject = {};
const urlImages = "/wp-content/plugins/rotate-360-images/assets/site/image/";

jQuery(document).ready(function () {
  const allTagRotate360Image = document.querySelectorAll(
    `.rota-rotate-360-image`
  );

  if (allTagRotate360Image.length == 0) {
    return;
  }
  
  let allRotate360ImageIDSTagsHtml = [];
  allTagRotate360Image.forEach((rotate360Image, index) => {
    if (
      rotate360Image.classList.contains(
        "rota-rotate-360-image-woocommerce-single-product"
      )
    ) {
      rotaChangeLocationRotate360Image(rotate360Image.id);
    }
    allRotate360ImageIDSTagsHtml.push(rotate360Image.id);
  });

  rotaRenderAllRotate360Image(allRotate360ImageIDSTagsHtml);
});

function rotaChangeLocationRotate360Image(rotate360ImageTagHtmlID) {
  setTimeout(function () {
    const rotate360ImageTagHtml = jQuery(`#${rotate360ImageTagHtmlID}`)[0]
      .outerHTML;
    jQuery(`#${rotate360ImageTagHtmlID}`).remove();
    jQuery(".woocommerce-product-gallery").append(rotate360ImageTagHtml);
  }, 400);
}

async function rotaRenderAllRotate360Image(allRotate360ImageIDSTagsHtml) {
  const rotate360ImageIDS = allRotate360ImageIDSTagsHtml.map(
    (rotate360ImageIDSTagsHtml) => {
      return rotate360ImageIDSTagsHtml.replace("rota-rotate-360-image-", "");
    }
  );

  const allRotate360Image = await rotaGetRotate360ImagesData(rotate360ImageIDS);
  rotarotaGenerateRotate360Images(allRotate360Image);
}

async function rotaGetRotate360ImagesData(allRotate360ImageIDS) {
  const rotate360Images = [];
  for (const rotate360ImageID of allRotate360ImageIDS) {
    const rotate360ImageData = await rotaGetRotate360ImageData(rotate360ImageID);
    if (!rotate360ImageData) {
      continue;
    }
    rotate360Images.push(rotate360ImageData);
  }
  return rotate360Images;
}

async function rotaGetRotate360ImageData(rotate360ImageID) {
  try {
    const response = await fetch(
      `/wp-json/rota-rotate-plugin/v1/get-rotate-plugin/${rotate360ImageID}`
    );
    return await response.json();
  } catch (error) {
    return false;
  }
}

function rotarotaGenerateRotate360Images(allRotate360Image) {
  for (const rotate360Image of allRotate360Image) {
    rotaGenerateRotate360Image(rotate360Image);
  }
}

function rotaGenerateRotate360Image(rotate360Image) {
  const rotate360ImageTagHtmlID = `#rota-rotate-360-image-${rotate360Image.id} `;

  document.querySelector(`${rotate360ImageTagHtmlID} .images`).src =
    rotate360Image.images[0];
  rotaAddTitleToRotate360Image(rotate360Image.title, rotate360ImageTagHtmlID);
  rotaAddButtonsRotate360Image(
    rotate360ImageTagHtmlID,
    rotate360Image.background_color_button
  );
  rotaInitThreesixty(rotate360ImageTagHtmlID, rotate360Image);
  document.querySelector(
    rotate360ImageTagHtmlID
  ).style.backgroundColor = `#${rotate360Image.background_color}`;
}

function rotaAddButtonsRotate360Image(
  rotate360ImageTagHtmlID,
  backgroundColorButton
) {
  const divButtonsRotate360Image = document.createElement("div");
  divButtonsRotate360Image.className = "rotate-360-image-buttons";

  const spanTagNextIconTag = document.createElement("span");
  spanTagNextIconTag.className = "rotate-360-image-button next";
  spanTagNextIconTag.style.backgroundColor = `#${backgroundColorButton}`;

  const nextIconImageTag = document.createElement("img");
  nextIconImageTag.src = urlImages + "/preview.png";

  spanTagNextIconTag.appendChild(nextIconImageTag);
  divButtonsRotate360Image.appendChild(spanTagNextIconTag);

  const spanTagPlayStopIconTag = document.createElement("span");
  spanTagPlayStopIconTag.className = "rotate-360-image-button play-stop stop";
  spanTagPlayStopIconTag.style.backgroundColor = `#${backgroundColorButton}`;
  const playStopIconImageTag = document.createElement("img");
  playStopIconImageTag.src = urlImages + "/stop.png";
  spanTagPlayStopIconTag.appendChild(playStopIconImageTag);
  divButtonsRotate360Image.appendChild(spanTagPlayStopIconTag);

  const spanTagPreviewIconTag = document.createElement("span");
  spanTagPreviewIconTag.className = "rotate-360-image-button prev";
  spanTagPreviewIconTag.style.backgroundColor = `#${backgroundColorButton}`;
  const previewIconImageTag = document.createElement("img");
  previewIconImageTag.src = urlImages + "/next.png";
  spanTagPreviewIconTag.appendChild(previewIconImageTag);
  divButtonsRotate360Image.appendChild(spanTagPreviewIconTag);

  document
    .querySelector(rotate360ImageTagHtmlID)
    .appendChild(divButtonsRotate360Image);
}

function rotaAddTitleToRotate360Image(title, rotate360ImageTagHtmlID) {
  const divRotate360Image = document.createElement("div");
  const rotate360ImageTag = document.querySelector(rotate360ImageTagHtmlID);
  divRotate360Image.className = "title-image-360-rotate";
  divRotate360Image.innerHTML = title;
  rotate360ImageTag.insertBefore(
    divRotate360Image,
    rotate360ImageTag.firstChild
  );
}

function rotaInitThreesixty(rotate360ImageTagHtmlID, rotate360Image) {
  rotate360Image.images.forEach((image) => {
    const imageTagHtml = document.createElement("img");
    imageTagHtml.src = image;
    document
      .querySelector(`${rotate360ImageTagHtmlID} .preload-images`)
      .appendChild(imageTagHtml);
  });

  const swipeOptions = {
    triggerOnTouchEnd: true,
    swipeStatus: function swipeStatus(event, phase, direction, distance) {
      rotaSetStopIcon(rotate360ImageTagHtmlID);
      rotaClearInterval(rotate360ImageTagHtmlID);
      rotaSwipeStatusCustom(
        direction,
        distance,
        rotate360Image.images,
        rotate360ImageTagHtmlID
      );
    },
    allowPageScroll: "vertical",
    threshold: 75,
  };

  const images = jQuery(`${rotate360ImageTagHtmlID} .images`);
  images.swipe(swipeOptions);

  rotaAutoRotate("right", rotate360ImageTagHtmlID, rotate360Image);
  rotaLoadEventListener(rotate360ImageTagHtmlID, rotate360Image);
}

function rotaAutoRotate(direction, rotate360ImageTagHtmlID, rotate360Image) {
  rotaClearInterval(rotate360ImageTagHtmlID);

  intervalAutoRotateObject[rotate360ImageTagHtmlID] = setInterval(() => {
    rotaChangeImage(direction, rotate360ImageTagHtmlID, rotate360Image.images);
  }, rotate360Image.speed);
}

function rotaChangeImage(direction, rotate360ImageTagHtmlID, images) {
  const imageUrl = document.querySelector(
    `${rotate360ImageTagHtmlID} .images`
  ).src;
  let number = parseInt(images.indexOf(imageUrl));
  if (direction == "right") {
    number++;

    if (number >= images.length) {
      number = 0;
    }
  } else if (direction == "left") {
    number--;
    if (number < 0) {
      number = images.length - 1;
    }
  }

  document.querySelector(`${rotate360ImageTagHtmlID} .images`).src =
    images[number];
}

function rotaSwipeStatusCustom(
  direction,
  distance,
  images,
  rotate360ImageTagHtmlID
) {
  if (direction == "left") {
    rotaChangeImageLeft(distance, images, rotate360ImageTagHtmlID);
  } else if (direction == "right") {
    rotaChangeImageRight(-distance, images, rotate360ImageTagHtmlID);
  }
}

function rotaSetStopIcon(rotate360ImageTagHtmlID) {
  const stopPlayButton = document.querySelector(
    `${rotate360ImageTagHtmlID} .play-stop`
  );
  const iconTagPlayStop = document.querySelector(
    `${rotate360ImageTagHtmlID} .play-stop img`
  );
  if (!stopPlayButton.classList.contains("stop")) {
    return;
  }
  stopPlayButton.classList.remove("stop");
  stopPlayButton.classList.add("play");
  iconTagPlayStop.src = `${urlImages}/play.png`;
}

function rotaSetPlayIcon(rotate360ImageTagHtmlID) {
  const stopPlayButton = document.querySelector(
    `${rotate360ImageTagHtmlID} .play-stop`
  );
  const iconTagPlayStop = document.querySelector(
    `${rotate360ImageTagHtmlID} .play-stop img`
  );

  if (!stopPlayButton.classList.contains("play")) {
    return;
  }

  stopPlayButton.classList.remove("play");
  stopPlayButton.classList.add("stop");
  iconTagPlayStop.src = `${urlImages}/stop.png`;
}

function rotaChangeImageLeft(imgNum, images, rotate360ImageTagHtmlID) {
  imgNum = Math.floor(imgNum / 8);

  if (imgNum < 1) {
    imgNum += images.length;
  }
  if (imgNum > images.length) {
    imgNum -= images.length;
  }

  document.querySelector(`${rotate360ImageTagHtmlID} .images`).src =
    images[imgNum - 1];
}

function rotaChangeImageRight(imgNum, images, rotate360ImageTagHtmlID) {
  imgNum = Math.floor(imgNum / 8);

  var num2 = -Math.abs(images.length);
  if (imgNum > num2) {
    imgNum += images.length;
  }
  if (imgNum <= num2) {
    imgNum += images.length * 2;
  }

  document.querySelector(`${rotate360ImageTagHtmlID} .images`).src =
    images[imgNum - 1];
}

function rotaClearInterval(rotate360ImageTagHtmlID) {
  if (intervalAutoRotateObject[rotate360ImageTagHtmlID]) {
    clearInterval(intervalAutoRotateObject[rotate360ImageTagHtmlID]);
  }
}

function rotaLoadEventListener(rotate360ImageTagHtmlID, rotate360Image) {
  const stopPlayButton = document.querySelector(
    `${rotate360ImageTagHtmlID} .play-stop`
  );
  const iconTagPlayStop = document.querySelector(
    `${rotate360ImageTagHtmlID} .play-stop img`
  );

  stopPlayButton.addEventListener("click", function () {
    if (stopPlayButton.classList.contains("play")) {
      stopPlayButton.classList.remove("play");
      stopPlayButton.classList.add("stop");
      iconTagPlayStop.src = `${urlImages}/stop.png`;
      rotaAutoRotate("right", rotate360ImageTagHtmlID, rotate360Image);
      return;
    }
    if (stopPlayButton.classList.contains("stop")) {
      stopPlayButton.classList.remove("stop");
      stopPlayButton.classList.add("play");
      iconTagPlayStop.src = `${urlImages}/play.png`;
      rotaClearInterval(rotate360ImageTagHtmlID);
      return;
    }
  });

  document
    .querySelector(`${rotate360ImageTagHtmlID} .next`)
    .addEventListener("click", function () {
      rotaSetPlayIcon(rotate360ImageTagHtmlID);
      rotaAutoRotate("right", rotate360ImageTagHtmlID, rotate360Image);
    });

  document
    .querySelector(`${rotate360ImageTagHtmlID} .prev`)
    .addEventListener("click", function () {
      rotaSetPlayIcon(rotate360ImageTagHtmlID);
      rotaAutoRotate("left", rotate360ImageTagHtmlID, rotate360Image);
    });
}
