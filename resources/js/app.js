/**
 * Сначала мы загрузим все зависимости JavaScript этого проекта, которые
 * включают Vue и другие библиотеки. Это отличная отправная точка при
 * создании надежных и мощных веб-приложений с использованием Vue и Laravel.
 */

import * as bootstrap from 'bootstrap';
import './bootstrap';
import {createApp} from 'vue';
import '../css/styles.css';
import '../css/login.css';

window.bootstrap = bootstrap;


/**
 * Далее мы создадим новый экземпляр приложения Vue. Затем вы можете начать
 * регистрацию компонентов в экземпляре приложения, чтобы они были готовы
 * к использованию в представлениях вашего приложения. Для вас приведен пример. */

const app = createApp({});

// import TestComponent from "./components/Test.vue";
// app.component('test', TestComponent);


/**
 * Следующий блок кода может быть использован для автоматической регистрации ваших Vue
 * компонентов. Он будет рекурсивно сканировать этот каталог на наличие Vue
 * компонентов и автоматически регистрировать их с их "базовым именем".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Object.entries(import.meta.glob('./**/*.vue', {eager: true})).forEach(([path, definition]) => {
    app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
});

/**
 * Наконец, мы прикрепим экземпляр приложения к HTML-элементу с
 * атрибутом "id" для "app". Этот элемент входит в состав строительных лесов "auth"
 * . В противном случае вам нужно будет добавить элемент самостоятельно.
 */

app.mount('#app');
