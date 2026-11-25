<?php

declare(strict_types=1);

namespace Greenter\Exception;

use Throwable;

/**
 * Interfaz común de las excepciones de Greenter.
 *
 * Contrato de errores:
 * - Errores de negocio (rechazos de SUNAT, SoapFault, errores HTTP del API GRE) no lanzan excepciones:
 *   se informan en el resultado (`BaseResult::isSuccess()` y `BaseResult::getError()`).
 * - Errores técnicos o de uso (documento sin builder, XML inválido, respuesta de SUNAT con formato
 *   inesperado) lanzan una excepción que implementa esta interfaz.
 *
 * Permite capturar cualquier error técnico de Greenter con `catch (GreenterException $e)`.
 */
interface GreenterException extends Throwable
{
}
