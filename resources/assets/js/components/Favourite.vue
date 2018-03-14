<template>
    <button type="submit" :class="classes" @click="toggle()">
        <span class="oi oi-heart" title="icon heart" aria-hidden="true"></span>
        <span v-text="count"></span>
    </button>
</template>

<script>
export default {
    props: ["reply"],

    data() {
        return {
            count: this.reply.favouritesCount,
            active: this.reply.isFavourited
        };
    },

    computed: {
        classes() {
            return {
                btn: true,
                "btn-primary": this.active == true,
                "btn-default": this.active == false
            };
        },
        endpoint() {
            return "/replies/" + this.reply.id + "/favourites";
        }
    },

    methods: {
        toggle() {
            this.active ? this.destroy() : this.create();
        },

        create() {
            axios.post(this.endpoint);
            this.active = true;
            this.count++;
        },

        destroy() {
            axios.delete(this.endpoint);
            this.active = false;
            this.count--;
        }
    }
};
</script>