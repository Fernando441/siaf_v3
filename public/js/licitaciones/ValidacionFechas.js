        $("#fecha_compra_bases").change(function() { 
            fecha_compra_bases = document.getElementById("fecha_compra_bases").value;
            fecha_entrega_propuestas = document.getElementById("fecha_entrega_propuestas").value;
            fecha_apertura_tecnica = document.getElementById("fecha_apertura_tecnica").value;
            fecha_apertura_economica = document.getElementById("fecha_apertura_economica").value;
            fecha_visita = document.getElementById("fecha_visita").value;
            fecha_preguntas = document.getElementById("fecha_preguntas").value;


            if(fecha_entrega_propuestas != "")
            {
                const cadena = fecha_entrega_propuestas;
                const [fecha_v] = cadena.split('T');
                fecha_propuestas = moment(fecha_v).format('DD/MM/YYYY' )

                if(fecha_compra_bases  > fecha_propuestas)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de compra de bases debe ser anterior a la fecha de entrega de propuestas !",
                    });

                    document.getElementById("fecha_compra_bases").value = "";      
                }
            }

            if(fecha_apertura_tecnica != "")
            {
                if(fecha_compra_bases  > fecha_apertura_tecnica)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de compra de bases debe ser anterior a la fecha de apertura de oferta técnica !",
                    });

                    document.getElementById("fecha_compra_bases").value = "";      
                }
            }


            if(fecha_apertura_economica != "")
            {
                if(fecha_compra_bases  > fecha_apertura_economica)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de compra de bases debe ser anterior a la fecha de apertura de oferta económica !",
                    });

                    document.getElementById("fecha_compra_bases").value = "";      
                }
            }


            if(fecha_visita != "")
            {
                const cadena = fecha_visita;
                const [fecha_v] = cadena.split('T');
                fecha_visita_dato = moment(fecha_v).format('DD/MM/YYYY' )

                if(fecha_compra_bases  > fecha_visita_dato)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de compra de bases debe ser anterior a la fecha de visita !",
                    });

                    document.getElementById("fecha_compra_bases").value = "";      
                }
            }

            if(fecha_preguntas != "")
            {
                const cadena = fecha_preguntas;
                const [fecha_v] = cadena.split('T');
                fecha_preguntas_dato = moment(fecha_v).format('DD/MM/YYYY' )

                if(fecha_compra_bases  > fecha_preguntas_dato)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de compra de bases debe ser anterior a la fecha de envío de preguntas !",
                    });

                    document.getElementById("fecha_compra_bases").value = "";      
                }
            }



        });
        // END Validacion de la fecha de compra de bases

        $("#fecha_entrega_propuestas").change(function() {
            fecha_compra_bases = document.getElementById("fecha_compra_bases").value;
            fecha_entrega_propuestas = document.getElementById("fecha_entrega_propuestas").value;

            const cadena = fecha_entrega_propuestas;
            const [fecha_v] = cadena.split('T');
            fecha_propuestas = moment(fecha_v).format('DD/MM/YYYY' )

            document.getElementById("apertura_proposiciones").value = fecha_propuestas; 

            if(fecha_compra_bases != "")
            {
                if(fecha_compra_bases  > fecha_propuestas)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de compra de bases debe ser anterior a la fecha de entrega de propuestas !",
                    });

                    document.getElementById("fecha_entrega_propuestas").value = "";      
                }

            }

        });
        // END Validacion de la fecha de entrega de propuestas 

        $("#fecha_apertura_tecnica").change(function() {
            fecha_compra_bases = document.getElementById("fecha_compra_bases").value;
            fecha_apertura_tecnica = document.getElementById("fecha_apertura_tecnica").value;
            fecha_entrega_propuestas = document.getElementById("fecha_entrega_propuestas").value;
            fecha_apertura_economica = document.getElementById("fecha_apertura_economica").value;
            acto_fallo = document.getElementById("acto_fallo").value;

            if(fecha_compra_bases != "")
            {
                if(fecha_compra_bases  > fecha_apertura_tecnica)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de compra de bases debe ser anterior a la fecha de apertura de oferta técnica !",
                    });

                    document.getElementById("fecha_apertura_tecnica").value = "";      
                }
            }

            if(fecha_entrega_propuestas != "")
            {
                const cadena = fecha_entrega_propuestas;
                const [fecha_v] = cadena.split('T');
                fecha_entrega_propuestas_dato =  moment(fecha_v).format('DD/MM/YYYY' )

                if( fecha_entrega_propuestas_dato > fecha_apertura_tecnica)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de oferta técnica debe ser similar o mayor a la fecha de entrega de propuestas !",
                    });

                    document.getElementById("fecha_apertura_tecnica").value = "";      
                }
            }


            if(fecha_apertura_economica != "")
            {
                if(fecha_apertura_tecnica  > fecha_apertura_economica)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de apertura de oferta técnica  debe ser anterior a la fecha de apertura de oferta económica !",
                    });

                    document.getElementById("fecha_apertura_tecnica").value = "";      
                }
            }


            if(acto_fallo != "")
            {
                if( fecha_apertura_tecnica > acto_fallo)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de acto de fallo debe ser posterior a la fecha de apertura de oferta técnica !",
                    });

                    document.getElementById("fecha_apertura_tecnica").value = "";      
                }
            }



        });
        // END Validacion de la fecha de apertura de oferta técnica


        $("#fecha_apertura_economica").change(function() {
            fecha_compra_bases = document.getElementById("fecha_compra_bases").value;
            fecha_apertura_economica = document.getElementById("fecha_apertura_economica").value;
            fecha_apertura_tecnica = document.getElementById("fecha_apertura_tecnica").value;
            acto_fallo = document.getElementById("acto_fallo").value;

            if(fecha_compra_bases != "")
            {
                if(fecha_compra_bases  > fecha_apertura_economica)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de compra de bases debe ser anterior a la fecha de apertura de oferta económica !",
                    });

                    document.getElementById("fecha_apertura_economica").value = "";      
                }

            }

            if(fecha_apertura_tecnica != "")
            {
                if(fecha_apertura_tecnica  > fecha_apertura_economica)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de apertura de oferta técnica  debe ser anterior a la fecha de apertura de oferta económica !",
                    });

                    document.getElementById("fecha_apertura_economica").value = "";      
                }
            }

            if(acto_fallo != "")
            {
                if( fecha_apertura_economica > acto_fallo)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de acto de fallo debe ser posterior a la fecha de apertura de oferta económica !",
                    });

                    document.getElementById("fecha_apertura_economica").value = "";      
                }
            }


        });
        // END Validacion de la fecha de apertura de oferta economica


        $("#fecha_visita").change(function() {
            fecha_compra_bases = document.getElementById("fecha_compra_bases").value;
            fecha_visita = document.getElementById("fecha_visita").value;

            const cadena = fecha_visita;
            const [fecha_v] = cadena.split('T');
            fecha_visita_dato = moment(fecha_v).format('DD/MM/YYYY' )

            if(fecha_compra_bases != "")
            {
                if(fecha_compra_bases  > fecha_visita_dato)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de compra de bases debe ser anterior a la fecha de visita !",
                    });

                    document.getElementById("fecha_visita").value = "";      
                }

            }

        });
        // END Validacion de la fecha de visita


        $("#fecha_preguntas").change(function() {
            fecha_compra_bases = document.getElementById("fecha_compra_bases").value;
            fecha_preguntas = document.getElementById("fecha_preguntas").value;
            junta_aclaraciones = document.getElementById("junta_aclaraciones").value;

                const cadena = fecha_preguntas;
                const [fecha_v] = cadena.split('T');
                fecha_preguntas_dato = moment(fecha_v).format('DD/MM/YYYY' )

            if(fecha_compra_bases != "")
            {


                if(fecha_compra_bases  > fecha_preguntas_dato)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de compra de bases debe ser anterior a la fecha de envío de preguntas !",
                    });

                    document.getElementById("fecha_preguntas").value = "";      
                }
            }


            if(junta_aclaraciones != "")
            {
                const cadena = junta_aclaraciones;
                const [fecha_v] = cadena.split('T');
                fecha_junta_aclaraciones_dato = moment(fecha_v).format('DD/MM/YYYY' )

                if(fecha_preguntas_dato  > fecha_junta_aclaraciones_dato)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de envío de preguntas debe ser anterior a la fecha de junta de aclaración de bases de concurso !",
                    });

                    document.getElementById("fecha_preguntas").value = "";      
                }
            }


        });
        // END Validacion de la Fecha y Hora de envío de preguntas    

        $("#junta_aclaraciones").change(function() {
            fecha_preguntas = document.getElementById("fecha_preguntas").value;
            junta_aclaraciones = document.getElementById("junta_aclaraciones").value;
            fecha_entrega_propuestas = document.getElementById("fecha_entrega_propuestas").value;
            fecha_repreguntas = document.getElementById("fecha_repreguntas").value;

                const cadena = junta_aclaraciones;
                const [fecha_v] = cadena.split('T');
                fecha_junta_aclaraciones_dato = moment(fecha_v).format('DD/MM/YYYY' )

            if(fecha_preguntas != "")
            {
                const cadena = fecha_preguntas;
                const [fecha_v] = cadena.split('T');
                fecha_preguntas_dato = moment(fecha_v).format('DD/MM/YYYY' )

                if(fecha_preguntas_dato  > fecha_junta_aclaraciones_dato)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de envío de preguntas debe ser anterior a la fecha de junta de aclaración de bases de concurso !",
                    });

                    document.getElementById("junta_aclaraciones").value = "";      
                }
            }

            if(fecha_entrega_propuestas != "")
            {
                const cadena = fecha_entrega_propuestas;
                const [fecha_v] = cadena.split('T');
                fecha_entrega_propuestas_dato =  moment(fecha_v).format('DD/MM/YYYY' )

                if(fecha_junta_aclaraciones_dato  > fecha_entrega_propuestas_dato)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de junta de aclaración de bases de concurso debe ser anterior a la fecha de entrega de propuestas !",
                    });

                    document.getElementById("junta_aclaraciones").value = "";      
                }
            }

            if(fecha_repreguntas != "")
            {

                if( fecha_repreguntas > fecha_junta_aclaraciones_dato)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de junta de aclaración de bases de concurso ser posterior a la fecha de repreguntas !",
                    });

                    document.getElementById("junta_aclaraciones").value = "";      
                }
            }


        });
        // END Validacion de la Fecha y hora de Junta de aclaración de bases de concurso    

        $("#fecha_entrega_propuestas").change(function() {
            junta_aclaraciones = document.getElementById("junta_aclaraciones").value;
            fecha_entrega_propuestas = document.getElementById("fecha_entrega_propuestas").value;
            fecha_apertura_tecnica = document.getElementById("fecha_apertura_tecnica").value;


                const cadena = fecha_entrega_propuestas;
                const [fecha_v] = cadena.split('T');
                fecha_entrega_propuestas_dato =  moment(fecha_v).format('DD/MM/YYYY' )

            if(junta_aclaraciones != "")
            {
                const cadena = junta_aclaraciones;
                const [fecha_v] = cadena.split('T');
                fecha_junta_aclaraciones_dato = moment(fecha_v).format('DD/MM/YYYY' )

                if(fecha_junta_aclaraciones_dato  > fecha_entrega_propuestas_dato)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de junta de aclaración de bases de concurso debe ser anterior a la fecha de entrega de propuestas !",
                    });

                    document.getElementById("fecha_entrega_propuestas").value = "";      
                }
            }

            if(fecha_apertura_tecnica != "")
            {

                if( fecha_entrega_propuestas_dato > fecha_apertura_tecnica)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de oferta técnica debe ser similar o mayor a la fecha de entrega de propuestas !",
                    });

                    document.getElementById("fecha_entrega_propuestas").value = "";      
                }
            }

        });
        // END Validacion de la fecha de entrega de propuestas      


        $("#fecha_entrega").change(function() {
            fecha_entrega = document.getElementById("fecha_entrega").value;
            acto_fallo = document.getElementById("acto_fallo").value;
            fecha_final_servicios = document.getElementById("fecha_final_servicios").value;

            if(acto_fallo != "")
            {
                if( acto_fallo > fecha_entrega)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de inicio de vigencia de los servicios debe ser posterior al dictamen o fallo !",
                    });

                    document.getElementById("fecha_entrega").value = "";      
                }
            }


            if(fecha_final_servicios != "")
            {
                if( fecha_entrega > fecha_final_servicios)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de final de vigencia de los servicios de los servicios debe ser posterior a la fecha de inicio de vigencia de los servicios !",
                    });

                    document.getElementById("fecha_entrega").value = "";      
                }
            }


        });
        // END Validacion de la Fecha de inicio de vigencia de los servicios
           

        $("#fecha_final_servicios").change(function() {
            fecha_entrega = document.getElementById("fecha_entrega").value;
            fecha_final_servicios = document.getElementById("fecha_final_servicios").value;

            if(fecha_entrega != "")
            {
                if( fecha_entrega > fecha_final_servicios)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de final de vigencia de los servicios de los servicios debe ser posterior a la fecha de inicio de vigencia de los servicios !",
                    });

                    document.getElementById("fecha_final_servicios").value = "";      
                }
            }

        });
        // END Validacion de la Fecha final de vigencia de los servicios

        $("#acto_fallo").change(function() {
            fecha_entrega = document.getElementById("fecha_entrega").value;
            acto_fallo = document.getElementById("acto_fallo").value;
            fecha_apertura_tecnica = document.getElementById("fecha_apertura_tecnica").value;
            fecha_apertura_economica = document.getElementById("fecha_apertura_economica").value;
            console.log(fecha_apertura_economica);
            console.log(acto_fallo);

            if(fecha_entrega != "")
            {
                if( acto_fallo > fecha_entrega)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de inicio de vigencia de los servicios debe ser posterior al dictamen o fallo !",
                    });

                    document.getElementById("acto_fallo").value = "";      
                }
            }

            if(fecha_apertura_tecnica != "")
            {
                if( fecha_apertura_tecnica > acto_fallo)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de acto de fallo debe ser posterior a la fecha de apertura de oferta técnica !",
                    });

                    document.getElementById("acto_fallo").value = "";      
                }
            }

            if(fecha_apertura_economica != "")
            {

                if( fecha_apertura_economica > acto_fallo)
                {       
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de acto de fallo debe ser posterior a la fecha de apertura de oferta económica !",
                    });

                    document.getElementById("acto_fallo").value = "";      
                }
            }


        });
        // END Validacion de la Fecha de acto de fallo

        
        $("#fecha_repreguntas").change(function() {
            junta_aclaraciones = document.getElementById("junta_aclaraciones").value;
            fecha_repreguntas = document.getElementById("fecha_repreguntas").value;

            if(junta_aclaraciones != "")
            {
                const cadena = junta_aclaraciones;
                const [fecha_v] = cadena.split('T');
                fecha_junta_aclaraciones_dato = moment(fecha_v).format('DD/MM/YYYY' )

                if( fecha_repreguntas > fecha_junta_aclaraciones_dato)
                {
                    Swal.fire({
                      icon: "warning",
                      title: "No se puede asignar esa fecha...",
                      text: "La fecha de junta de aclaración de bases de concurso ser posterior a la fecha de repreguntas !",
                    });

                    document.getElementById("fecha_repreguntas").value = "";      
                }
            }

        });
        // END Validacion de la Fecha de repreguntas
