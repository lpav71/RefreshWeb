<template>
    <div class="home">
        <div class="header">
            <div class="left">
                <div class="top"><img alt="" src="img/design/logo.svg"/><span style="margin-left: 14px;">Дизайн</span></div>
            </div>
        </div>
        <div class="bottom">
            <div class="row">
                <div class="col-3">
                    <div>
                        <span class="span-1">Название игрового центра</span>
                        <input class="div_4" type="text">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div>
                        <span class="span-1">Лого игрового центра</span>
                        <div class="img-logo">
                            <img alt="" height="94" src="img/design/obo.png" width="374">
                            <input id="img" class="div_4" type="file">
                            <label class="btn file-add" for="img"><img alt="" src="img/design/btnicon.svg"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div>
                        <span class="span-1">Обои и видеообои</span>
                        <select v-model="zone" class="btn btn-success">
                            <option disabled selected value="">Выберите зону</option>
                            <option v-for="t in 3">Value</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div>
                        <span class="span-1">Обои экрана входа</span>
                        <img :src="setting.login_image" alt="" height="200" width="350">
                    </div>
                </div>
                <div class="col-4">
                    <div>
                        <span class="span-1">Обои экрана после входа</span>
                        <img alt="" height="200" src="img/design/obo.png" width="350">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div>
                        <span class="span-1">Выберите цветовую гамму</span>
                        <div class="color-gamma">
                            <span style="margin-left: 10px;">Предзаготовки</span><br>
                            <div class="zagotovki">
                                <div :style="{background: setting.color1}" class="color-blank"></div>
                                <div :style="{background: setting.color2}" class="color-blank"></div>
                                <div :style="{background: setting.color3}" class="color-blank"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-success">Сохранить</button>
        </div>
    </div>

    <message ref="message"></message>
</template>

<script>

export default {
    name : "Disign",
    props: ['club_id'],
    data() {
        return {
            setting: {}
        }
    },
    methods: {
        async getSetting() {
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

            var response = await fetch("api/club/setting/disign", requestOptions);
            if (response.ok) {
                this.setting = await response.json();
            } else {
                this.$refs.message.modal.show();
            }
        }

    },
    mounted() {
        this.getSetting();
    }
}
</script>

<style lang="scss" scoped>

.color-blank {
    width         : 40px;
    height        : 40px;
    border-radius : 5px;
}

.home {
    width       : 1793px;
    height      : 815px;
    color       : var(--standart-gray);
    margin-left : 11px;

    .header {
        display         : flex;
        justify-content : space-between;
        height          : 33px;

        .left {
            width : 1060px;
        }

        .top {
            width   : 235px;
            height  : 42px;
            display : inline-block;
        }
    }

    .bottom {
        width         : 1793px;
        height        : 771px;
        background    : var(--light-blue-bg-color);
        margin-top    : 10px;
        border-radius : 20px;
        padding       : 20px;

        #img {
            display : none;
        }

        .img-logo {
            width   : 374px;
            height  : 94px;
            display : flex;
        }

        .file-add {
            width   : 30px;
            display : flex;
        }

        .color-gamma {
            width         : 250px;
            height        : 82px;
            background    : #122733;
            border-radius : 5px;
            margin-bottom : 30px;
            padding-top   : 5px;
        }

        .zagotovki {
            display         : flex;
            justify-content : space-evenly;
            margin-top      : 5px;
        }
    }

    .butt {
        background    : var(--disable);
        border        : none;
        border-radius : 5px 30px;
        height        : 42px;
        min-width     : 270px;
        padding-right : 20px;
        padding-left  : 20px;
        display       : inline-block;
    }

    .span-1 {
        margin-top    : 14px;
        display       : block;
        font-size     : inherit;
        margin-bottom : 7px;
    }

    .div_4 {
        height        : 35px;
        background    : #172d39;
        padding       : 5px 15px 5px 15px;
        margin-top    : 1px;
        color         : var(--standart-gray);
        border        : none;
        width         : 100%;
        border-radius : 8px;
        font-size     : inherit;
    }
}
</style>
