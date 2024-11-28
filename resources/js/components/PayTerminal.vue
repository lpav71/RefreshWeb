<template>
    <div class="home">
        <div class="header">
            <div class="left">
                <div class="top"><img alt="" src="img/4.svg"/><span style="margin-left: 14px;">Платежный терминал</span></div>
                <button class="btn btn-success" type="button">Автопоиск ККТ</button>
            </div>
        </div>
        <div class="bottom row">
            <div class="col-md-2">
                <div>
                    <span class="span-1">Тип касссы</span>
                    <select v-model="cashbox_type" class="div_4">
                        <option v-for="t in cashbox_type_name" :value="t.id">{{ t.name }}</option>
                    </select>
                </div>
                <div>
                    <span class="span-1">Тип соединения</span>
                    <select v-model="cashbox_connect_type" class="div_4">
                        <option v-for="t in cashbox_connect_type_name" :value="t.id">{{ t.name }}</option>
                    </select>
                </div>
                <div>
                    <span class="span-1">Порт</span>
                    <input v-model="cashbox_connect_address" class="div_4" @input="numVerify">
                </div>
                <div>
                    <span class="span-1">Скорость соединения</span>
                    <select v-model="speed" class="div_4">
                        <option v-for="t in 3">Value</option>
                    </select>
                </div>
                <div>
                    <span class="span-1">Канал обмена с ОФД</span>
                    <select v-model="channel" class="div_4">
                        <option v-for="t in 3">Value</option>
                    </select>
                </div>
                <button class="btn btn-success mt-4" style="width: 100px" type="button" @click="save">Сохранить</button>
            </div>
            <div class="col-md-2">
                <div>
                    <span class="span-1">Тип ПТ</span>
                    <select v-model="terminal_type" class="div_4">
                        <option value="0">Сбербанк</option>
                    </select>
                </div>
                <div>
                    <span class="span-1">Путь к дистрибутиву ПТ</span>
                    <input v-model="terminal_soft" class="div_4">
                </div>
            </div>
        </div>
    </div>

    <message ref="message"></message>
</template>

<script>

export default {
    props: ['club_id'],
    data() {
        return {
            terminal_type            : 0,
            terminal_soft            : '',
            cashbox_type             : 1,
            cashbox_connect_type     : 1,
            cashbox_connect_address  : '',
            cashbox_type_name        : [],
            cashbox_connect_type_name: []
        }
    },
    methods: {
        numVerify(e) {
            this.cashbox_connect_address = verifyNum(e);
        },
        async cashboxType() {
            var requestOptions = {
                method  : 'POST',
                redirect: 'follow'
            };

            var response = await fetch("api/cashbox_type", requestOptions);
            if (response.ok) {
                this.cashbox_type_name = await response.json();
            }
        },
        async cashboxConnectType() {
            var requestOptions = {
                method  : 'POST',
                redirect: 'follow'
            };

            var response = await fetch("api/cashbox_connect_type", requestOptions);
            if (response.ok) {
                this.cashbox_connect_type_name = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        },
        async save() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append("terminal_type", this.terminal_type);
            urlencoded.append("terminal_soft", this.terminal_soft);
            urlencoded.append("cashbox_type", this.cashbox_type);
            urlencoded.append("cashbox_connect_type", this.cashbox_connect_type);
            urlencoded.append("cashbox_connect_address", this.cashbox_connect_address);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/cashbox/save", requestOptions);
            if (!response.ok) {
                this.$refs.message.modal.show();
            }
        },
        async setting() {
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

            var response = await fetch("api/cashbox/setting", requestOptions);
            if (response.ok) {
                var result                   = await response.json();
                this.cashbox_connect_address = result.connect_address;
                this.terminal_type           = result.terminal_type;
                this.cashbox_type            = result.type;
                this.cashbox_connect_type    = result.connect_type;
                this.terminal_soft           = result.terminal_soft;
                console.log(result);
            } else {
                this.$refs.message.modal.show();
            }
        }
    },
    mounted() {
        this.cashboxType();
        this.cashboxConnectType();
        this.setting();
    }
}
</script>

<style scoped>
.span-1 {
    margin-top : 14px;
    display    : block;
    font-size  : inherit;
}

.div_4 {
    height        : 35px;
    background    : #172d39;
    padding       : 5px 15px 5px 15px;
    margin-top    : 1px;
    color         : var(--standart-gray);
    border        : none;
    width         : 190px;
    border-radius : 8px;
    font-size     : inherit;
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

.home .header {
    width           : 516px;
    display         : flex;
    justify-content : start;
}

.bottom {
    width         : 1793px;
    height        : 756px;
    background    : var(--light-blue-bg-color);
    margin-top    : 10px;
    border-radius : 20px;
    padding       : 20px;
    margin-left   : 0;
}

.top {
    width   : 235px;
    height  : 42px;
    display : inline-block;
}
</style>
