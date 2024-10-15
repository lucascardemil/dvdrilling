import axios from 'axios';

export default {
    data() {
        return {
            detalleHoras: [],
            errors_detalleHoras: [],
            loading_create: false
        };
    },
    methods: {

        async fetchDetalleHoras(id) {
            this.loading = true;
            this.errors_detalleHoras = null;
            try {
                const response = await axios.get(`/api/detalleHoras/all/${id}`);
                this.detalleHoras = response.data;
            } catch (error) {
                this.errors_detalleHoras = 'Failed to load detalleHoras';
                console.error('Error fetching detalleHoras:', error);
            } finally {
                this.loading = false;
            }
        },

        async createDetalleHoras(data) {
            this.loading_create = true;
            this.errors_detalleHoras = null;
            try {
                const response = await axios.post('/api/detalleHoras/store', data);

                if (response.data.errors) {
                    this.errors_detalleHoras = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_detalleHoras = 'Failed to load detalleHoras';
                console.error('Error crear detalleHoras:', error);
            } finally {
                this.loading_create = false;
            }
        },

        async actualizarDetalleHora(data) {
            this.loading_create = true;
            this.errors_detalleHoras = null;
            try {
                const response = await axios.put('/api/detalleHoras/update/' + data.id, {
                    de: data.de,
                    a: data.a,
                    actividad_id: data.actividad_id,
                    reporte_id: data.reporte_id
                });

                if (response.data.errors) {
                    this.errors_detalleHoras = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_detalleHoras = 'Failed to load detalleHoras';
                console.error('Error actualizar detalleHoras:', error);
            } finally {
                this.loading_create = false;
            }
        },

        async deleteDetalleHora(id) {
            this.loading = true;
            this.errors_detalleHoras = null;
            try {
                const response = await axios.delete('/api/detalleHoras/delete/' + id);

                if (response.data.errors) {
                    this.errors_detalleHoras = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_detalleHoras = 'Failed to load detalleHoras';
                console.error('Error actualizar detalleHoras:', error);
            } finally {
                this.loading = false;
            }
        },


    }
};
