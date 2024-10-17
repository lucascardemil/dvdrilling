import axios from 'axios';

export default {
    data() {
        return {
            reportes: [],
            loading_create: false,
            loading: false,
            errors_reporte: null
        };
    },
    methods: {

        async fetchReportes() {
            this.loading = true;
            this.errors_reporte = null;
            try {
                const response = await axios.get(`/reportes/all`);
                this.reportes = response.data;
            } catch (error) {
                this.errors_reporte = 'Failed to load reportes';
                console.error('Error fetching reportes:', error);
            } finally {
                this.loading = false;
            }
        },

        async createReporte(data) {
            this.loading_create = true;
            this.errors_reporte = null;
            try {
                const response = await axios.post('/reportes/store', data);

                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors_reporte = response.data.errors;
                }

                // Maneja la respuesta exitosa, si es necesario
                return response.data;

            } catch (error) {
                this.errors_reporte = 'Failed to load reporte';
                console.error('Error crear reporte:', error);
            } finally {
                this.loading_create = false;
            }
        },

        async actualizarReporte(data) {
            this.loading = true;
            this.errors_reporte = null;
            try {
                const response = await axios.put('/reportes/update/' + data.reporte_id, {
                    proyecto_id: data.proyecto_id,
                    sondaje: data.sondaje,
                    fecha: data.fecha,
                    empresa: data.empresa,
                    sonda: data.sonda,
                    turno: data.turno,
                    horas: data.horas,
                    desde: data.desde,
                    hasta: data.hasta,
                    total: data.total,
                    metros: data.metros,
                    inclinacion: data.inclinacion,
                    rumbo: data.rumbo,
                    programa: data.programa,
                    diametro: data.diametro
                });

                if (response.data.errors_reporte) {
                    this.errors_reporte = response.data.errors_reporte;
                }

                return response.data;

            } catch (error) {
                this.errors_reporte = 'Failed to load reporte';
                console.error('Error actualizar reporte:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarStatus(data) {
            this.loading = true;
            this.errors_reporte = null;
            try {
                const response = await axios.put('/reportes/update-status/' + data.reporte_id, {
                    status: data.status
                });

                if (response.data.errors_reporte) {
                    this.errors_reporte = response.data.errors_reporte;
                }

                return response.data;

            } catch (error) {
                this.errors_reporte = 'Failed to load reporte';
                console.error('Error actualizar reporte:', error);
            } finally {
                this.loading = false;
            }
        },

        async descargarPDF(reporte) {
            console.log(reporte);
            try {
                const response = await axios({
                    url: '/reportes/pdf',  // URL de la API
                    method: 'POST',
                    data: { reporte },
                    responseType: 'blob'  // Importante para recibir el archivo como Blob
                });

                // Crear un objeto URL desde el Blob
                const url = window.URL.createObjectURL(response.data, { type: 'application/pdf' });

                // Abrir el PDF en una nueva pestaña
                window.open(url, '_blank');

            } catch (error) {
                this.errors_reporte = 'Failed to load reporte';
                console.error('Error crear reporte:', error);
            } finally {
                this.loading_create = false;
            }
        },
    }
};
