import axios from 'axios';

export default {
    data() {
        return {
            aditivos: [],
            errors_aditivos: [],
            loading_create: false
        };
    },
    methods: {

        async fetchAditivos(id) {
            this.loading = true;
            this.errors_aditivos = null;
            try {
                const response = await axios.get(`/api/aditivos/all/${id}`);
                this.aditivos = response.data;
            } catch (error) {
                this.errors_aditivos = 'Failed to load aditivos';
                console.error('Error fetching aditivos:', error);
            } finally {
                this.loading = false;
            }
        },

        async createAditivos(data) {
            this.loading_create = true;
            this.errors_aditivos = null;
            try {
                const response = await axios.post('/api/aditivos/store', data);

                if (response.data.errors) {
                    this.errors_aditivos = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_aditivos = 'Failed to load aditivos';
                console.error('Error crear aditivos:', error);
            } finally {
                this.loading_create = false;
            }
        },

        async actualizarAditivo(data) {
            this.loading = true;
            this.errors_aditivos = null;
            try {
                const response = await axios.put('/api/aditivos/update/' + data.id, {
                    detalle: data.detalle,
                    cantidad: data.cantidad
                });

                if (response.data.errors) {
                    this.errors_aditivos = response.data.errors_reporte;
                }

                return response.data;

            } catch (error) {
                this.errors_aditivos = 'Failed to load aditivos';
                console.error('Error actualizar aditivos:', error);
            } finally {
                this.loading = false;
            }
        },

        async deleteAditivo(id) {
            this.loading = true;
            this.errors_aditivos = null;
            try {
                const response = await axios.delete('/api/aditivos/delete/' + id);

                if (response.data.errors) {
                    this.errors_aditivos = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_aditivos = 'Failed to load aditivos';
                console.error('Error actualizar aditivos:', error);
            } finally {
                this.loading = false;
            }
        },


    }
};
