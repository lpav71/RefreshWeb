<template>
    <div class="home">
        <div class="header">
            <div class="left">
                <div class="top"><img alt="" src="img/4.svg"/><span style="margin-left: 14px;">Склад</span><i
                    class="fa fa-search lupa"></i><input v-model="product_name" class="input_shop" placeholder="Поиск товаров" type="text" @keydown="enter"/>
                    <button class="btn btn-success butt" type="button">Все</button>
                    <button class="btn btn-success butt" type="button">Товары</button>
                    <button class="btn btn-success butt" type="button">Услуги</button>
                    <button class="btn btn-success butt" type="button">Скоро закончатся</button>
                </div>
            </div>
            <div>
                <button class="btn btn-success butt" type="button">Внесение</button>
                <button class="btn btn-success butt" type="button" @click="writeOff">Списание</button>
                <button class="btn btn-success butt" type="button" @click="editModal">Добавить</button>
            </div>
        </div>
        <div class="bottom">
            <div class="in-bottom">
                <div v-for="(g, index) in goods" class="goods">
                    <div class="goods_img"><img :src="g.icon" alt="" height="200"></div>
                    <div class="goods_text">
                        <div>{{ g.name }}</div>
                        <br>
                        <div>{{ g.product }} {{ g.product_param }}</div>
                    </div>
                    <div class="goods-btn">
                        <span>{{ g.num }}</span>
                        <div>
                            <button class="goods_cart" style="margin-right: 10px;" type="button" @click="add(index)"><i class="fa fa-plus fa-lg"></i>
                            </button>
                            <button class="goods_cart" type="button" @click="editModal(index)"><i class="fa fa-edit fa-lg"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно Добавить товар -->
    <div id="editWarehouseModal" aria-hidden="true" aria-labelledby="editWarehouseModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="editWarehouseModalLabel" class="modal-title">Добавить товар</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body" style="padding-left: 15px;">
                    <div class="block" style="margin-top: 0">
                        <span>Наименование товара</span>
                        <input v-model="product.product" class="input" placeholder="Введите наименование товара" type="text"/>
                    </div>
                    <div class="block" style="margin-top: 0">
                        <span>Стоимость закупки</span>
                        <input v-model="product.purchase" class="input" placeholder="Введите стоимость закупки" type="text" @input="numVerifyPurchase"/>
                    </div>
                    <div class="block" style="margin-top: 0">
                        <span>Стоимость продажи</span>
                        <input v-model="product.price" class="input" placeholder="Введите стоимость продажи" type="text" @input="numVerify"/>
                    </div>
                    <div class="block" style="margin-top: 0">
                        <span>Количество позиций товара</span>
                        <input v-model="product.num" class="input" placeholder="Введите количество позиций товара" type="text" @input="numVerifyQty"/>
                    </div>
                    <div class="block" style="margin-top: 0">
                        <span>Ссылка на картинку</span>
                        <input v-model="product.icon" class="input" placeholder="Введите ссылку" type="text"/>
                    </div>
                    <div class="block" style="margin-top: 0">
                        <span>Штрихкод товара</span>
                        <input v-model="product.barcode" class="input" placeholder="Введите штрихкод" type="text"/>
                    </div>
                    <div class="block">
                        <span>Запретить скидки на товар</span>
                        <select v-model="product.discount" class="input">
                            <option v-for="u in allowDiscount" :value="u.value">{{ u.name }}</option>
                        </select>
                    </div>
                    <div class="block">
                        <span>Список категорий товаров</span>
                        <select v-model="product.types" class="input">
                            <option v-for="u in product_types" :value="u.types">{{ u.name }}</option>
                        </select>
                    </div>
                    <div class="block">
                        <span>Система налогообложения</span>
                        <select v-model="product.nalog" class="input">
                            <option v-for="u in nalogTypes" :value="u.code">{{ u.name }}</option>
                        </select>
                    </div>
                    <div class="block-2">
                        <input v-model="product.showInClient" class="form-check-input" type="checkbox">
                        <label class="form-check-label"> - Показывать в клиентском ПО</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" @click="saveAddModal">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно Списание -->
    <div id="writeOffModal" aria-hidden="true" aria-labelledby="writeOffModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="writeOffModalLabel" class="modal-title">Списание</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <div class="block" style="margin-top: 0">
                        <span>Позиция</span>
                        <select v-model="position" class="input">
                            <option v-for="g in goods" :value="g.storeid">{{ g.product }} {{ g.product_param }}</option>
                        </select>
                    </div>
                    <div class="block" style="margin-top: 0">
                        <span>Причина списания</span>
                        <select v-model="typeOperation" class="input">
                            <option v-for="o in operationTypes" :value="o.id">{{ o.name }}</option>
                        </select>
                    </div>
                    <div class="block" style="margin-top: 0">
                        <span>Количество изымаемого товара</span>
                        <input v-model="num" class="input" type="text" @input="qtyGoods"/>
                    </div>
                    <div class="block" style="margin-top: 0">
                        <span>Комментарий</span>
                        <textarea v-model="description" class="input" style="height: 100px" type="text"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" @click="writeOffSave">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно Поступление товара -->
    <div id="receiptGoodsModal" aria-hidden="true" aria-labelledby="receiptGoodsModalLabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="receiptGoodsModalLabel" class="modal-title">Поступление товара</h5>
                    <button aria-label="Закрыть" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <div class="block" style="margin-top: 0">
                        <span>Наименование товара</span>
                        <input v-model="product.product" class="input" placeholder="Введите наименование товара" type="text"/>
                    </div>
                    <div class="block" style="margin-top: 0">
                        <span>Кол-во позиций товара</span>
                        <input v-model="product.qty" class="input" placeholder="Кол-во позиций товара" type="text"/>
                    </div>
                    <div class="block" style="margin-top: 0">
                        <span>Данные документа прихода</span>
                        <input v-model="product.doc" class="input" placeholder="Данные документа прихода" type="text"/>
                    </div>
                    <div class="block" style="margin-top: 0">
                        <span>Дата документа</span>
                        <input id="date" v-model="product.date" class="input" placeholder="Дата документа" type="text" @click="calendarShow"/>
                    </div>
                    <div class="block" style="margin-top: 0">
                        <span>Данные поставщика</span>
                        <input v-model="product.provider" class="input" placeholder="Данные поставщика" type="text"/>
                    </div>
                    <calendar ref="calandar" @item-selected="calendarSelect"></calendar>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" @click="addStoreCreate">Сохранить изменения</button>
                </div>
            </div>
        </div>
    </div>

    <message ref="message"></message>

</template>

<script>
import {createLog} from '../logger';

export default {
    props: ['club_id', 'user_id'],
    data() {
        return {
            product_name     : '',
            goods            : null,
            outData          : null,
            modal            : null,
            allowDiscount    : [
                {name: 'Да', value: true},
                {name: 'Нет', value: false}
            ],
            product          : {},
            product_types    : {},
            writeOffModal    : null,
            position         : 0,
            num              : '',
            description      : '',
            receiptGoodsModal: null,
            storeid          : 0,
            operationTypes   : [],
            typeOperation    : '',
            nalogTypes       : [
                {'code': 1, 'name': 'ОСН'},
                {'code': 2, 'name': 'УСН'},
                {'code': 3, 'name': 'ПСН'}
            ]
        }
    },
    methods: {
        qtyGoods(e) {
            this.num = verifyNum(e);
        },
        numVerify(e) {
            this.product.price = verifyNumDouble(e);
        },
        numVerifyPurchase(e) {
            this.product.purchase = verifyNumDouble(e);
        },
        numVerifyQty(e) {
            this.product.num = verifyNum(e);
        },
        add(i) {
            this.receiptGoodsModal.show();
            this.product         = {};
            this.product.product = this.goods[i].product + ' ' + this.goods[i].product_param;
            this.storeid         = this.goods[i].storeid;
        },
        calendarShow() {
            this.$refs.calandar.top  = date.offsetTop + 40;
            this.$refs.calandar.left = date.offsetLeft;
            this.$refs.calandar.show();
        },
        calendarSelect() {
            var day           = this.$refs.calandar.selectedDay;
            var month         = this.$refs.calandar.currentMonth + 1;
            var year          = this.$refs.calandar.currentYear;
            var date          = new Date(year, month - 1, day);
            this.product.date = date.getDate() + '.' + (date.getMonth() + 1) + '.' + date.getFullYear();
            this.$refs.calandar.hide();
        },
        async addStoreCreate() {
            this.receiptGoodsModal.hide();
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("store_id", this.storeid);
            urlencoded.append("user_id", this.$props.user_id);
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("product", JSON.stringify(this.product));

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/warehouse/add", requestOptions);
            if (!response.ok) {
                this.$refs.message.modal.show();
            }
        },
        writeOff() {
            this.position    = 0;
            this.num         = '';
            this.description = '';
            this.writeOffModal.show();
        },
        async writeOffSave() {
            this.writeOffModal.hide();
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("user_id", this.$props.user_id);
            urlencoded.append("position", this.position);
            urlencoded.append("num", this.num);
            urlencoded.append("description", this.description);
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("type_id", this.typeOperation);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/store-out/save", requestOptions);
            if (response.ok) {
                var data = {
                    "position"   : this.position,
                    "num"        : this.num,
                    "description": this.description,
                    "club_id"    : this.$props.club_id,
                    "type_id"    : this.typeOperation
                }
                createLog(JSON.stringify(data), 'Списание товара со склада', 'warehouse', this.$props.user_id)
            } else {
                this.$refs.message.modal.show();
            }
        },
        enter(e) {
            if (e.keyCode === 13) {
                this.find();
            }
        },
        editModal(i) {
            this.modal.show();
            if (isNaN(i)) { // Добавить
                this.product = {};
            } else { //Изменить
                this.product = this.goods[i];
            }
        },
        //Добавление или изменение товара
        async addEditGoods(product) {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/json");

            var raw = JSON.stringify(product);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : raw,
                redirect: 'follow'
            };

            var response = await fetch("api/store/addedit", requestOptions);
            if (response.ok) {
                createLog(JSON.stringify(product), 'Добавление товара на склад', 'warehouse', this.$props.user_id);
            } else {
                this.$refs.message.modal.show();
            }
            this.getAll();
        },
        saveAddModal() {
            this.modal.hide();
            this.product.club_id  = this.$props.club_id;
            this.product.admin_id = this.$props.user_id;
            this.addEditGoods(this.product);
        },
        async find() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("search", this.product_name);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/shop/find", requestOptions);
            if (response.ok) {
                this.goods = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        },
        async getAll() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/shop/get", requestOptions);
            if (response.ok) {
                this.outData       = await response.json();
                this.goods         = this.outData[0];
                this.product_types = this.outData[1];
            } else {
                this.$refs.message.modal.show();
            }
        },
        async getStoreOparationType() {
            var requestOptions = {
                method  : 'POST',
                redirect: 'follow'
            };

            var response = await fetch("api/store/operation/type", requestOptions);
            if (response.ok) {
                this.operationTypes = await response.json();
            }
        }
    },
    mounted() {
        var editWarehouseModal = document.getElementById('editWarehouseModal')
        this.modal             = bootstrap.Modal.getOrCreateInstance(editWarehouseModal);

        var writeOffModal  = document.getElementById('writeOffModal')
        this.writeOffModal = bootstrap.Modal.getOrCreateInstance(writeOffModal);

        var receiptGoodsModal  = document.getElementById('receiptGoodsModal')
        this.receiptGoodsModal = bootstrap.Modal.getOrCreateInstance(receiptGoodsModal);

        this.getAll();
        this.getStoreOparationType();
    }
}
</script>

<style scoped>
.modal-body {
    padding : 15px;
}

.home {
    width       : 1793px;
    height      : 815px;
    color       : var(--standart-gray);
    margin-left : 11px;
}

.home .header {
    display         : flex;
    justify-content : space-between;
}

.home .header .left {
    width : 1060px;
}

.modal-content {
    background : var(--light-blue-bg-color);
    color      : var(--standart-gray);
}

.modal-footer {
    justify-content : flex-start;
}

.block {
    display        : flex;
    flex-direction : column;
    align-items    : flex-start;
    margin-top     : 20px;
}

.block-2 {
    margin-top : 20px;
}

.block-2 label {
    margin : 3px 0 0 7px;
}

.input {
    height        : 35px;
    background    : #172d39;
    padding       : 5px 15px 5px 15px;
    margin-top    : 6px;
    color         : var(--standart-gray);
    border        : none;
    padding-top   : 2px;
    width         : 465px;
    border-radius : 8px;
}

.bottom {
    width         : 1793px;
    height        : 752px;
    background    : var(--light-blue-bg-color);
    margin-top    : 20px;
    border-radius : 20px;
    padding       : 20px;
}

.in-bottom {
    overflow   : auto;
    flex-wrap  : wrap;
    display    : flex;
    max-height : 809px;
}

.butt {
    margin-left : 10px;
    min-width   : 94px;
}

.lupa {
    position : relative;
    left     : 48px;
    opacity  : 0.50;
    top      : 0;
}

.top {
    width           : 1490px;
    height          : 42px;
    display         : flex;
    justify-content : start;
    align-items     : center;
}

.input_shop {
    margin-left    : 20px;
    background     : var(--standart-black);
    height         : 42px;
    display        : flex;
    flex-direction : row;
    align-items    : center;
    padding        : 10px 20px;
    gap            : 10px;
    width          : 376px;
    box-shadow     : 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius  : 10px;
    flex           : none;
    order          : 0;
    flex-grow      : 0;
    border         : none;
    color          : var(--standart-color);
    padding-left   : 50px;
}

.goods {
    width         : 178px;
    height        : 281px;
    background    : var(--standart-black);
    margin-right  : 15px;
    padding       : 11px;
    border-radius : 12px;
    margin-bottom : 15px;
}

.goods_img {
    width           : 156px;
    height          : 200px;
    display         : flex;
    justify-content : center;
    background      : var(--standart-color);
    overflow        : hidden;
    border-radius   : 10px;
}

.goods_text {
    width           : 156px;
    height          : 22px;
    display         : flex;
    justify-content : space-between;
    font-size       : 10px;
    flex-direction  : column;
    line-height     : 8px;
    margin-top      : 7px;
}

.goods-btn {
    width           : 154px;
    height          : 25px;
    display         : flex;
    justify-content : space-between;
    align-items     : center;
    font-size       : 10px;
    margin-top      : 4px;
}

.goods_cart {
    border        : none;
    border-radius : 4px;
    background    : var(--dark-green);
    color         : var(--standart-color);
    width         : 30px;
    height        : 25px;
}
</style>
