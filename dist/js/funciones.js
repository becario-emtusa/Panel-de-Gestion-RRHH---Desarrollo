/* Devuelve todas las horas dada una fecha */
export function getHoraporFecha($pFecha, Horas_por_fecha) {
    try {
        var valores = [];

        for (let elemento of Horas_por_fecha) {
            const fechaCal = moment(elemento[0], $('#daterangepicker').data('daterangepicker').format);

            if (fechaCal.isSame($pFecha)) {
                valores.push(elemento[1]);
            }
        }

        for (let index = valores.length - 1; index >= 1; index--) {
            if (valores[index].slice(0, 5) === valores[index - 1].slice(0, 5)) {
                valores.pop(valores[index]);
            }
        }

        return valores;
    } catch (e) {
        console.log(e);
    }
}