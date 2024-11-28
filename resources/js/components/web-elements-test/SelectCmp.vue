<template>
    <label>
        <slot></slot>
    </label>
    <div :id="id" :style="{height: height + 'px', width: width + 'px', background: bg}" class="selector" @click="show">
        <img v-if="image" :src="imageSrc" alt="" width="45">
        {{ selectedItem.label }}
        <i class="fa  fa-chevron-circle-down"></i>
    </div>
    <div v-if="showdiv" :class="{ 'show': fade }" :style="{height: heightItems + 'px', width: width + 'px', top: top + 'px', left: left + 'px'}" class="items" @click="hide">
        <div v-for="(item, index) in items" class="item" @click="selection(index)">{{ item.label }}</div>
    </div>
</template>

<script>
export default {
    name : "Select-cmp",
    props: ['idn'],
    data() {
        return {
            items       : [],
            height      : 35,
            width       : 190,
            bg          : 'linear-gradient(180deg, #172d39 0%, #122834 100%)',
            heightItems : 300,
            selectedItem: {value: '0', label: 'Выберите...'},
            opacity     : 1,
            top         : 0,
            left        : 20,
            showItems   : false,
            itm         : false,
            showdiv     : false,
            id          : 1,
            fade        : false,
            image       : false,
            imageSrc    : ''
        }
    },
    methods: {
        hide() {
            this.fade = false;
            this.$nextTick(() => {
                setTimeout(function () {
                    this.showdiv = false;
                }.bind(this), 1000)
            });
        },
        show(e) {
            var targetElement = e.target;
            var fa            = targetElement.classList[0];
            if (fa == 'fa') {
                targetElement = targetElement.closest('.selector')
            }
            this.top         = targetElement.offsetTop + this.height + 2;
            var count        = this.items.length;
            this.heightItems = count * 35;
            this.showdiv     = true;
            this.$nextTick(() => {
                setTimeout(function () {
                    this.fade = true;
                }.bind(this), 100)
            });
        },
        selection(i) {
            this.selectedItem = this.items[i];
        }
    },
    mounted() {
        this.id = this.$props.idn;
    }
}
</script>

<style scoped>
.show {
    opacity : 1 !important;
}

label {
    color : var(--standart-gray);
}

.selector {
    padding         : 5px 15px 5px 15px;
    margin-top      : 5px;
    border          : none;
    width           : 190px;
    border-radius   : 8px;
    font-size       : inherit;
    color           : var(--standart-gray);
    cursor          : pointer;
    position        : relative;
    display         : flex;
    justify-content : space-between;
    align-items     : center;
}

.items {
    padding             : 5px 15px 5px 15px;
    margin-top          : 5px;
    border              : none;
    border-radius       : 8px;
    font-size           : inherit;
    background          : var(--light-blue-bg-color-2);
    color               : var(--standart-gray);
    cursor              : pointer;
    transition-duration : 800ms;
    position            : absolute;
    z-index             : 1;
    opacity             : 0;
}

.item {
    padding : 5px;
}

.item:hover {
    background    : var(--light-blue-menu-color);
    color         : #0c3541;
    border-radius : 5px;
}
</style>
