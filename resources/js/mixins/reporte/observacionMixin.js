import axios from 'axios';

export default {
    data() {
        return {
            errors_observacion: [],
            loading_create: false,
        };
    },
    methods: {
        async createObservacion(data) {
            this.loading_create = true;
            this.errors_observacion = null;
            try {
                const response = await axios.post('/api/observaciones/store', data);

                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors_observacion = response.data.errors;
                }

                // Maneja la respuesta exitosa, si es necesario
                return response.data;

            } catch (error) {
                this.errors_observacion = 'Failed to load observacion';
                console.error('Error crear observacion:', error);
            } finally {
                this.loading_create = false;
            }
        },

    }
};
