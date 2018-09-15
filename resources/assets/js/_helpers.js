
function str_replace_all(find, replace, str) {
    return str.replace(new RegExp(find, 'g'), replace);
}
