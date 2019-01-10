# ree
Plugin para Jeedom para la consulta diaria de los precios de las tarifas de la  luz de Red Eléctrica Española

Este plugin nos permitirá consultar de forma diaria las tarifas PVPC españolas, cuyos precios del día siguiente los da REE a través
la API esios normalmente antes de las 22 horas de cada día. Por tanto, tenemos la tarifa diaria desde las 0 horas del mismo día.

Trás esto, podemos activar el plugin en Jeedom, dentro de la configuración del mismo necesitamos configurar el token personal que tenemos
que solicitar a REE en la dirección consultasios@ree.es, la respuesta suele ser bastante rápida.

Por último, ya solo nos queda crear nuestro equipo y elegir de que tarifa queremos que muestre los datos.
- PVPC: Tarifa normal de precio voluntario pequeño consumidor.
- PVPC 2.0 DHA: Tarifa con discriminación horaria de precio voluntario pequeño consumidor.
- PVPC 2.0 DHS: Tarifa cn discriminación horaria coche eléctrico de precio voluntario pequeño consumidor.

Nos aparecerán 24 comandos, 1 por cada hora en la que nos indica el precio de esa hora en la tarifa seleccionada. Además, 2 comandos que nos indican la hora más cara y más
barata del día, el precio de la hora actual y el nombre de la tarifa que hemos elegido.
