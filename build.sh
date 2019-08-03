#!/bin/sh

npm install && grunt

rm -Rf gridd-plus
rm -f gridd-plus.zip
rm -Rf ../gridd-plus2
cp -R . ../gridd-plus2
mv ../gridd-plus2 ./gridd-plus

# Remove extra files.
rm -rf gridd-plus/.sass-cache
rm -rf gridd-plus/node_modules
rm -f gridd-plus/.browserslistrc
rm -f gridd-plus/.editorconfig
rm -f gridd-plus/.eslintignore
rm -f gridd-plus/.eslintrc.json
rm -rf gridd-plus/.git
rm -f gridd-plus/.gitignore
rm -f gridd-plus/.gitmodules
rm -f gridd-plus/package-lock.json
rm -f gridd-plus/composer.lock
rm -f gridd-plus/*.sh
rm -f gridd-plus/*.json
rm -f gridd-plus/*.js
rm -f gridd-plus/*.dist
rm -Rf gridd-plus/vendor

find ./gridd-plus/ -name "*.map" -type f -delete
find ./gridd-plus/ -name "*.scss" -type f -delete

zip -rq gridd-plus.zip gridd-plus
rm -Rf gridd-plus/