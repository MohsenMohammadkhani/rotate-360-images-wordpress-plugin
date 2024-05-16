let rotaPaginationItemOnClickHandler;
let rotaCountPage;
let rotaCurrentPage;
let rotaTags = [];
const rotaAddEllipsis = () => {
  return `<div class="rota-p-2">
            <span>.....</span>
        </div>`;
};

const rotaAddButton = (page, active = false) => {
  return `<div class="rota-p-2">
        <span
         class="${active ? "button" : "button-primary"}"
         onclick="rotaPaginationItemOnClickHandler(${page})"
         data-number=${page}
        >${rotaToPersianNum(page)}</span></div>`;
};

const rotaAddButtonArrow = (arrow, page) => {
  let content = arrow == "left" ? ">" : "<";
  return `<div class="rota-p-2">
        <span
        class="button-primary "
        onclick="rotaPaginationItemOnClickHandler(${page})" 
        data-number=${page}
        >${content}</span></div>`;
};
const rotaGenerateTagPageCurrentOne = () => {
  switch (rotaCountPage) {
    case 1:
      break;

    case 2:
      rotaTags.push(rotaAddButton(1, true));
      rotaTags.push(rotaAddButton(2));
      rotaTags.push(rotaAddButtonArrow("left", rotaCurrentPage + 1));
      break;

    case 3:
      rotaTags.push(rotaAddButton(1, true));
      rotaTags.push(rotaAddButton(2));
      rotaTags.push(rotaAddButton(3));
      rotaTags.push(rotaAddButtonArrow("left", rotaCurrentPage + 1));
      break;

    case 4:
      rotaTags.push(rotaAddButton(1, true));
      rotaTags.push(rotaAddButton(2));
      rotaTags.push(rotaAddEllipsis());
      rotaTags.push(rotaAddButton(4));
      rotaTags.push(rotaAddButtonArrow("left", rotaCurrentPage + 1));
      break;

    default:
      rotaTags.push(rotaAddButton(1, true));
      rotaTags.push(rotaAddButton(2));
      rotaTags.push(rotaAddEllipsis());
      rotaTags.push(rotaAddButton(rotaCountPage));
      rotaTags.push(rotaAddButtonArrow("left", rotaCurrentPage + 1));
      break;
  }
};

const rotaGenerateTagPageCurrentTwo = () => {
  switch (rotaCountPage) {
    case 2:
      rotaTags.push(rotaAddButtonArrow("right", rotaCurrentPage - 1));
      rotaTags.push(rotaAddButton(1));
      rotaTags.push(rotaAddButton(2, true));
      break;

    case 3:
      rotaTags.push(rotaAddButtonArrow("right", rotaCurrentPage - 1));
      rotaTags.push(rotaAddButton(1));
      rotaTags.push(rotaAddButton(2, true));
      rotaTags.push(rotaAddButton(3));
      rotaTags.push(rotaAddButtonArrow("left", rotaCurrentPage + 1));
      break;

    case 4:
      rotaTags.push(rotaAddButtonArrow("right", rotaCurrentPage - 1));
      rotaTags.push(rotaAddButton(1));
      rotaTags.push(rotaAddButton(2, true));
      rotaTags.push(rotaAddButton(3));
      rotaTags.push(rotaAddButton(4));
      rotaTags.push(rotaAddButtonArrow("left", rotaCurrentPage + 1));
      break;

    default:
      rotaTags.push(rotaAddButtonArrow("right", rotaCurrentPage - 1));
      rotaTags.push(rotaAddButton(1));
      rotaTags.push(rotaAddButton(2, true));
      rotaTags.push(rotaAddButton(3));
      rotaTags.push(rotaAddEllipsis());
      rotaTags.push(rotaAddButton(rotaCountPage));
      rotaTags.push(rotaAddButtonArrow("left", rotaCurrentPage + 1));
      break;
  }
};

const rotaGenerateTagPageCurrentThree = () => {
  switch (rotaCountPage) {
    case 3:
      rotaTags.push(rotaAddButtonArrow("right", rotaCurrentPage - 1));
      rotaTags.push(rotaAddButton(1));
      rotaTags.push(rotaAddButton(2));
      rotaTags.push(rotaAddButton(3, true));
      break;

    case 4:
      rotaTags.push(rotaAddButtonArrow("right", rotaCurrentPage - 1));
      rotaTags.push(rotaAddButton(1));
      rotaTags.push(rotaAddButton(2));
      rotaTags.push(rotaAddButton(3, true));
      rotaTags.push(rotaAddButton(4));
      rotaTags.push(rotaAddButtonArrow("left", rotaCurrentPage + 1));
      break;

    default:
      rotaTags.push(rotaAddButtonArrow("right", rotaCurrentPage - 1));
      rotaTags.push(rotaAddButton(1));
      rotaTags.push(rotaAddEllipsis());
      rotaTags.push(rotaAddButton(2));
      rotaTags.push(rotaAddButton(3, true));
      rotaTags.push(rotaAddButton(4));
      rotaTags.push(rotaAddEllipsis());
      rotaTags.push(rotaAddButton(rotaCountPage));
      rotaTags.push(rotaAddButtonArrow("left", rotaCurrentPage + 1));
      break;
  }
};

const rotaGenerateTagPageCurrentNormal = () => {
  rotaTags.push(rotaAddButtonArrow("right", rotaCurrentPage - 1));
  rotaTags.push(rotaAddButton(1));
  rotaTags.push(rotaAddEllipsis());
  rotaTags.push(rotaAddButton(rotaCurrentPage - 1));
  rotaTags.push(rotaAddButton(rotaCurrentPage, true));
  rotaTags.push(rotaAddButton(rotaCurrentPage + 1));
  rotaTags.push(rotaAddEllipsis());
  rotaTags.push(rotaAddButton(rotaCountPage));
  rotaTags.push(rotaAddButtonArrow("left", rotaCurrentPage + 1));
};

const rotaGenerateTagPageCurrentEqualCountPage = () => {
  rotaTags.push(rotaAddButtonArrow("right", rotaCurrentPage - 1));
  rotaTags.push(rotaAddButton(1));
  rotaTags.push(rotaAddEllipsis());
  rotaTags.push(rotaAddButton(rotaCountPage - 1));
  rotaTags.push(rotaAddButton(rotaCountPage, true));
};

const rotaGenerateTagPageCurrentEqualCountPageOneLess = () => {
  rotaTags.push(rotaAddButtonArrow("right", rotaCurrentPage - 1));
  rotaTags.push(rotaAddButton(1));
  rotaTags.push(rotaAddEllipsis());
  rotaTags.push(rotaAddButton(rotaCurrentPage - 1));
  rotaTags.push(rotaAddButton(rotaCurrentPage, true));
  rotaTags.push(rotaAddButton(rotaCountPage));
  rotaTags.push(rotaAddButtonArrow("left", rotaCurrentPage + 1));
};

const rotaGenerateTagPageCurrentEqualCountPageTowLess = () => {
  rotaTags.push(rotaAddButtonArrow("right", rotaCurrentPage - 1));
  rotaTags.push(rotaAddButton(1));
  rotaTags.push(rotaAddEllipsis());
  rotaTags.push(rotaAddButton(rotaCurrentPage - 1));
  rotaTags.push(rotaAddButton(rotaCurrentPage, true));
  rotaTags.push(rotaAddButton(rotaCurrentPage + 1));
  rotaTags.push(rotaAddButton(rotaCountPage));
  rotaTags.push(rotaAddButtonArrow("left", rotaCurrentPage + 1));
};

function rotaMakePagination(
  rotaCountPageParam,
  rotaCurrentPageParam,
  rotaPaginationItemOnClickHandlerParam
) {
  rotaTags = [];
  rotaPaginationItemOnClickHandler = rotaPaginationItemOnClickHandlerParam;
  rotaCurrentPage = parseInt(rotaCurrentPageParam);
  rotaCountPage = parseInt(rotaCountPageParam);

  switch (true) {
    case rotaCurrentPage == 1:
      rotaGenerateTagPageCurrentOne();
      break;

    case rotaCurrentPage == 2:
      rotaGenerateTagPageCurrentTwo();
      break;

    case rotaCurrentPage == 3:
      rotaGenerateTagPageCurrentThree();
      break;

    case rotaCurrentPage > 3 && rotaCurrentPage < rotaCountPage - 2:
      rotaGenerateTagPageCurrentNormal();
      break;

    case rotaCurrentPage == rotaCountPage - 2:
      rotaGenerateTagPageCurrentEqualCountPageTowLess();
      break;

    case rotaCurrentPage == rotaCountPage - 1:
      rotaGenerateTagPageCurrentEqualCountPageOneLess();
      break;

    case rotaCurrentPage == rotaCountPage:
      rotaGenerateTagPageCurrentEqualCountPage();
      break;
  }

  return `<div class="rota-pagination">${rotaTags.join("")}</div>`;
}
