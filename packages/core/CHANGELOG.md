# Greenter Changes

## Aug 2019-08-10 Core
**Invoice**
- Se agregó `MtoBaseIvap`.
- Se agregó `MtoIvap`.

**Note**
- Se agregó `MtoBaseIvap`.
- Se agregó `MtoIvap`.

## Nov 2018-11-05 Core
**Summary**
- Se agregó `Moneda`.

**Summary Detail**
- Se agrego `MtoIvap`.

**CdrResponse**
- Se agregó `isAccepted()`, indica cuando un cdr es aceptado. 

## Oct 2018-10-14 UBL 2.1

**Invoice**
- Se agregó `UblVersion`, valores esperados: **2.0** o **2.1**.
- `TipoDeOperacion` es requerido, ahora se toma del catálogo 51.
- `Legends` ahora se toma del catálogo 52.
- Se agregó `TotalImpuestos` es requerido.
- Se agregó `ValorVenta` es requerido.
- Se agregó `MtoBaseIsc`.
- Se agregó `MtoBaseOth`.
- Se agregó `MtoOperExportacion`.
- Se agrego `Cargos`.
- Se agrego `Descuentos`.
- Se agrego `Compra`.

**Invoice Detail**
- Se agregó `TotalImpuestos` es requerido.
- Se agregó `MtoBaseIgv` es requerido. 
- Se agregó `PorcentajeIgv` es requerido.
- Se agregó `MtoBaseIsc`. 
- Se agregó `PorcentajeIsc`.
- Se agrego `Cargos`.
- Se agrego `Descuentos`.

**Note**
- Se agregó `UblVersion`, valores esperados: **2.0** o **2.1**.
- `Legends` ahora se toma del catálogo 52.
- Se agregó `TotalImpuestos` es requerido.
- Se agregó `MtoBaseIsc`.
- Se agregó `MtoBaseOth`.
- Se agregó `MtoOperExportacion`.
- Se agrego `Compra`.

**Address**
- Se agregó `CodLocal`, código asignado por SUNAT para el establecimiento anexo declarado en el RUC (opcional).

**SalePerception**
- El codigo de régimen se toma del catálogo 53.
- Se agrego `porcentaje`.

**Detraction**
- Se agregó `CtaBanco`.
- Se agregó `CodMedioPago`, ver catálogo 59.
- Se agregó `CodBienDetraccion`, ver catálogo 54.

**Charge** (Descuentos y Cargos)
- `codTipo` ver catálogo 53.

## Feb 2018-02-16
- Add notificator, notification, attachment files.
- Purpouse
    - Email
    - WebConsult
