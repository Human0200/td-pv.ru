<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}

if (TSolution::getFrontParametrValue('COMPACT_FOOTER_MOBILE') === 'Y') {
    TSolution\Extensions::init('accordion_grid');
}

