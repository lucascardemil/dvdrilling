import axios from 'axios';

export default {
    data() {
        return {
            errors_herramienta: [],
            loading_create: false,
        };
    },
    methods: {
        async createHerramienta(data) {
            this.loading_create = true;
            this.errors_herramienta = null;
            try {
                const response = await axios.post('/herramientas/store', data);

                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors_herramienta = response.data.errors;
                }

                // Maneja la respuesta exitosa, si es necesario
                return response.data;

            } catch (error) {
                this.errors_herramienta = 'Failed to load horometro';
                console.error('Error crear horometro:', error);
            } finally {
                this.loading_create = false;
            }
        },

    }
};
