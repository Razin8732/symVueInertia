composer create-project symfony/skeleton ./
composer require webapp

### FOR INERTIA JS
composer require twig encore symfony/serializer-pack
composer require rompetomp/inertia-bundle
yarn add @inertiajs/inertia
yarn install
yarn dev

-> setup  root template

yarn add @inertiajs/inertia-vue

-> modify webpack.config.js (for vue)

yarn add vue@^2.5 vue-loader@^15.9.5 vue-template-compiler

yarn watch

composer require friendsofsymfony/jsrouting-bundle
php bin/console assets:install --symlink public


