<?php
if (!defined('ABSPATH')) exit;

$paginationItemOnClickHandler = "";
$countPage = 0;
$currentPage = 1;
$tags = [];
function rotaAddEllipsis()
{
    echo esc_html("<div class='p-2'><span>.....</span></div>");
}

function rotaAddButton($page, $active = false)
{
    $page = rotaToPersianNumber($page);
    echo esc_html(
        "<div class='p-2'>
        <span class='btn px-3 ${active ? 'rota-btn-hover' : 'rota-btn'}'
              onclick='paginationItemOnClickHandler($page)'
              data-number='$page'>$page</span></div>");
}

function rotaAddButtonArrow($arrow, $page)
{
    $arrow == "left" ? ">" : "<";
    echo esc_html(
        "<div class='p-2'>
        <span
        class='btn fps-btn''
        onclick='paginationItemOnClickHandler($page)' 
        data-number=$page
        >$arrow</span></div>"
    );
}

function rotaGenerateTagPageCurrentOne()
{
    global $countPage, $tags, $currentPage;
    switch ($countPage) {
        case 1:
            break;

        case 2:
            array_push($tags, rotaAddButton(1, true));
            array_push($tags, rotaAddButton(2));
            array_push($tags, rotaAddButtonArrow("left", $currentPage + 1));
            break;

        case 3:
            array_push($tags, rotaAddButton(1, true));
            array_push($tags, rotaAddButton(2));
            array_push($tags, rotaAddButton(3));
            array_push($tags, rotaAddButtonArrow("left", $currentPage + 1));
            break;

        case 4:
            array_push($tags, rotaAddButton(1, true));
            array_push($tags, rotaAddButton(2));
            array_push($tags, rotaAddEllipsis());
            array_push($tags, rotaAddButton(4));
            array_push($tags, rotaAddButtonArrow("left", $currentPage + 1));
            break;

        default:
            array_push($tags, rotaAddButton(1, true));
            array_push($tags, rotaAddButton(2));
            array_push($tags, rotaAddEllipsis());
            array_push($tags, rotaAddButton($countPage));
            array_push($tags, rotaAddButtonArrow("left", $currentPage + 1));
            break;
    }
}

function rotaGenerateTagPageCurrentTwo()
{
    global $countPage, $tags, $currentPage;
    switch ($countPage) {
        case 2:
            array_push($tags, rotaAddButtonArrow("right", $currentPage - 1));
            array_push($tags, rotaAddButton(1));
            array_push($tags, rotaAddButton(2, true));
            break;

        case 3:
            array_push($tags, rotaAddButtonArrow("right", $currentPage - 1));
            array_push($tags, rotaAddButton(1));
            array_push($tags, rotaAddButton(2, true));
            array_push($tags, rotaAddButton(3));
            array_push($tags, rotaAddButtonArrow("left", $currentPage + 1));
            break;

        case 4:
            array_push($tags, rotaAddButtonArrow("right", $currentPage - 1));
            array_push($tags, rotaAddButton(1));
            array_push($tags, rotaAddButton(2, true));
            array_push($tags, rotaAddButton(3));
            array_push($tags, rotaAddButton(4));
            array_push($tags, rotaAddButtonArrow("left", $currentPage + 1));
            break;

        default:
            array_push($tags, rotaAddButtonArrow("right", $currentPage - 1));
            array_push($tags, rotaAddButton(1));
            array_push($tags, rotaAddButton(2, true));
            array_push($tags, rotaAddButton(3));
            array_push($tags, rotaAddEllipsis());
            array_push($tags, rotaAddButton($countPage));
            array_push($tags, rotaAddButtonArrow("left", $currentPage + 1));
            break;
    }
}

function rotaGenerateTagPageCurrentThree()
{
    global $countPage, $tags, $currentPage;
    switch ($countPage) {
        case 3:
            array_push($tags, rotaAddButtonArrow("right", $currentPage - 1));
            array_push($tags, rotaAddButton(1));
            array_push($tags, rotaAddButton(2));
            array_push($tags, rotaAddButton(3, true));
            break;

        case 4:
            array_push($tags, rotaAddButtonArrow("right", $currentPage - 1));
            array_push($tags, rotaAddButton(1));
            array_push($tags, rotaAddButton(2));
            array_push($tags, rotaAddButton(3, true));
            array_push($tags, rotaAddButton(4));
            array_push($tags, rotaAddButtonArrow("left", $currentPage + 1));
            break;

        default:
            array_push($tags, rotaAddButtonArrow("right", $currentPage - 1));
            array_push($tags, rotaAddButton(1));
            array_push($tags, rotaAddEllipsis());
            array_push($tags, rotaAddButton(2));
            array_push($tags, rotaAddButton(3, true));
            array_push($tags, rotaAddButton(4));
            array_push($tags, rotaAddEllipsis());
            array_push($tags, rotaAddButton($countPage));
            array_push($tags, rotaAddButtonArrow("left", $currentPage + 1));
            break;
    }
}

function rotaGenerateTagPageCurrentNormal()
{
    global $countPage, $tags, $currentPage;
    array_push($tags, rotaAddButtonArrow("right", $currentPage - 1));
    array_push($tags, rotaAddButton(1));
    array_push($tags, rotaAddEllipsis());
    array_push($tags, rotaAddButton($currentPage - 1));
    array_push($tags, rotaAddButton($currentPage, true));
    array_push($tags, rotaAddButton($currentPage + 1));
    array_push($tags, rotaAddEllipsis());
    array_push($tags, rotaAddButton($countPage));
    array_push($tags, rotaAddButtonArrow("left", $currentPage + 1));
}

function rotaGenerateTagPageCurrentEqualCountPage()
{
    global $countPage, $tags, $currentPage;
    array_push($tags, rotaAddButtonArrow("right", $currentPage - 1));
    array_push($tags, rotaAddButton(1));
    array_push($tags, rotaAddEllipsis());
    array_push($tags, rotaAddButton($countPage - 1));
    array_push($tags, rotaAddButton($countPage, true));
}

function rotaGenerateTagPageCurrentEqualCountPageOneLess()
{
    global $countPage, $tags, $currentPage;
    array_push($tags, rotaAddButtonArrow("right", $currentPage - 1));
    array_push($tags, rotaAddButton(1));
    array_push($tags, rotaAddEllipsis());
    array_push($tags, rotaAddButton($currentPage - 1));
    array_push($tags, rotaAddButton($currentPage, true));
    array_push($tags, rotaAddButton($countPage));
    array_push($tags, rotaAddButtonArrow("left", $currentPage + 1));
}

function rotaGenerateTagPageCurrentEqualCountPageTowLess()
{
    global $countPage, $tags, $currentPage;
    array_push($tags, rotaAddButtonArrow("right", $currentPage - 1));
    array_push($tags, rotaAddButton(1));
    array_push($tags, rotaAddEllipsis());
    array_push($tags, rotaAddButton($currentPage - 1));
    array_push($tags, rotaAddButton($currentPage, true));
    array_push($tags, rotaAddButton($currentPage + 1));
    array_push($tags, rotaAddButton($countPage));
    array_push($tags, rotaAddButtonArrow("left", $currentPage + 1));
}

