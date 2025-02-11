DROP TABLE IF EXISTS sunat_52;
CREATE TABLE sunat_52(
   codigo      VARCHAR(4) NOT NULL PRIMARY KEY
  ,descripcion VARCHAR(98) NOT NULL
);
INSERT INTO sunat_52(codigo,descripcion) VALUES
 ('1000','Monto en Letras')
,('1002','Leyenda "TRANSFERENCIA GRATUITA DE UN BIEN Y/O SERVICIO PRESTADO GRATUITAMENTE"')
,('2000','Leyenda “COMPROBANTE DE PERCEPCIÓN”')
,('2001','Leyenda “BIENES TRANSFERIDOS EN LA AMAZONÍA REGIÓN SELVA PARA SER CONSUMIDOS EN LA MISMA"')
,('2002','Leyenda “SERVICIOS PRESTADOS EN LA AMAZONÍA  REGIÓN SELVA PARA SER CONSUMIDOS EN LA MISMA”')
,('2003','Leyenda “CONTRATOS DE CONSTRUCCIÓN EJECUTADOS  EN LA AMAZONÍA REGIÓN SELVA”')
,('2004','Leyenda “Agencia de Viaje - Paquete turístico”')
,('2005','Leyenda “Venta realizada por emisor itinerante”')
,('2006','Leyenda "Operación sujeta a detracción"')
,('2007','Leyenda "Operación sujeta al IVAP"')
,('2008','Leyenda: “VENTA EXONERADA DEL IGV-ISC-IPM. PROHIBIDA LA VENTA FUERA DE LA ZONA COMERCIAL DE TACNA”')
,('2009','Leyenda: “PRIMERA VENTA DE MERCANCÍA IDENTIFICABLE ENTRE USUARIOS DE LA ZONA COMERCIAL”')
,('2010','Restitucion Simplificado de Derechos Arancelarios')
,('2011','Leyenda “EXPORTACION DE SERVICIOS - DECRETO LEGISLATIVO Nº 919”');
