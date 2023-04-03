/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";
$(".numbers").keyup(function () {
    this.value = this.value.replace(/[^0-9\.]/g, "");
});
