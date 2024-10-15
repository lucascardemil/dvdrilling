<template>
    <div>
        <h3>Activos y Tipos De Activos</h3>
        <ul class="nav nav-tabs my-3">
            <li class="nav-item">
                <a class="nav-link" :class="{ active: activeTab === 'activo' }" @click="showTab('activo')" href="#">
                    Activo
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" :class="{ active: activeTab === 'tipo_activo' }" @click="showTab('tipo_activo')" href="#">
                    Tipos de Activo
                </a>
            </li>
        </ul>
        <ActivoComponent v-if="activeTab === 'activo'"></ActivoComponent>
        <TipoActivoComponent v-if="activeTab === 'tipo_activo'"></TipoActivoComponent>
    </div>
</template>


<script>
import ActivoComponent from './ActivoComponent.vue';
import TipoActivoComponent from '../TipoActivo/TipoActivoComponent.vue';

export default {
    data() {
        return {
            activeTab: 'activo',
        };
    },
    components: {
        ActivoComponent,
        TipoActivoComponent
    },
    methods: {
        showTab(tab) {
            this.activeTab = tab;
        }
    }
}
</script>
