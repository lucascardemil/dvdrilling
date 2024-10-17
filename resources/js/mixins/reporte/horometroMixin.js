import axios from 'axios';

export default {
    data() {
        return {
            errors_horometro: [],
            loading_create: false,
        };
    },
    methods: {
        async createHorometro(data) {
            this.loading_create = true;
            this.errors_horometro = null;
            try {
                const response = await axios.post('/horometros/store', data);

                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors_horometro = response.data.errors;
                }

                // Maneja la respuesta exitosa, si es necesario
                return response.data;

            } catch (error) {
                this.errors_horometro = 'Failed to load horometro';
                console.error('Error crear horometro:', error);
            } finally {
                this.loading_create = false;
            }
        },

    }
};
