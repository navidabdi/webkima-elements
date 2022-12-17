const glob = require('glob');
const path = require("path");
const jsFiles = glob.sync('./assets/src/js/**.js').reduce(function(obj, el){
  obj[path.parse(el).name] = el;
  return obj
},{});
const cssFiles = glob.sync('./assets/src/css/**.scss').reduce(function(obj, el){
  obj[path.parse(el).name] = el;
  return obj
},{});
let allFiles = {};
for (const key in cssFiles) {
  if (jsFiles[key]) {
    allFiles[key] = [jsFiles[key], cssFiles[key]];
  }
  else {
    allFiles[key] = cssFiles[key];
  }
}
// let allFiles = Object.assign(cssFiles, jsFiles);
console.log(allFiles);