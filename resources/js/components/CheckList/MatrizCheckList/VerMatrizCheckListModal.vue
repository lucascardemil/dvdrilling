<template>
    <div>
        <ul class="list-group">
            <template v-for="categoria in matrizChecklist.categorias">
                <li class="list-group-item">
                    <h5 class="titulo-categoria">{{ categoria.nombre }}</h5>
                </li>
                <template v-for="intervencion in categoria.intervenciones">
                    <li class="list-group-item">{{ intervencion.nombre }}</li>
                </template>
            </template>
        </ul>
    </div>
</template>

<script>

export default {
    mixins: [],
    props: {
        matrizChecklist: Object
    },
    components: {

    },
    data() {
        return {

        };
    },
    methods: {

    }
}
</script>

<style scoped>
.titulo-categoria {
    margin-bottom: 0;
    color: #6c757d;
    white-space: nowrap;
}
</style>