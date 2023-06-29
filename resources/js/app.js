/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;
import './bootstrap';
import { createApp } from 'vue';
import '../css/styles.css';
import '../css/login.css';


/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});


/*import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);*/

import PlaceComponent from "./components/Place.vue";
app.component('place', PlaceComponent);
import LeftMenuComponent from "./components/LeftMenu.vue";
app.component('left-menu', LeftMenuComponent);
import TopComponent from "./components/Top.vue";
app.component('top', TopComponent);
import UsersComponent from "./components/Users.vue";
app.component('users', UsersComponent);
import GamesComponent from "./components/Games.vue";
app.component('games', GamesComponent);
import FinanceComponent from "./components/Finance.vue";
app.component('finance', FinanceComponent);
import BookingComponent from "./components/Booking.vue";
app.component('booking', BookingComponent);
import ShopComponent from "./components/Shop.vue";
app.component('shop', ShopComponent);
import MapComponent from "./components/Map.vue";
app.component('maps', MapComponent);
import PromoComponent from "./components/Promo.vue";
app.component('promo', PromoComponent);
import DashboardComponent from "./components/Dashboard.vue";
app.component('dashboard', DashboardComponent);
import TaskComponent from "./components/Task.vue";
app.component('task', TaskComponent);
import UserInfoComponent from "./components/UserInfo.vue";
app.component('userinfo', UserInfoComponent);
import WarehouseComponent from "./components/Warehouse.vue";
app.component('warehouse', WarehouseComponent);
import TariffsComponent from "./components/Tariffs.vue";
app.component('tariffs', TariffsComponent);
import PayTerminalComponent from "./components/PayTerminal.vue";
app.component('pay-terminal', PayTerminalComponent);
import PositionComponent from "./components/Position.vue";
app.component('position', PositionComponent);
import LicensesComponent from "./components/Licenses.vue";
app.component('licenses', LicensesComponent);
import MessageComponent from "./components/Message.vue";
app.component('message', MessageComponent);
import ContextComponent from "./components/ContextMenu.vue";
app.component('context', ContextComponent);
import DesignComponent from "./components/Design.vue";
app.component('design', DesignComponent);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
