const ESTADOS = {
  pendiente:    { label: 'Pendiente',      clase: 'bg-amber-50 text-amber-700 border border-amber-200', punto: 'bg-amber-500' },
  preparacion:  { label: 'En Preparación', clase: 'bg-blue-50 text-blue-700 border border-blue-200',     punto: 'bg-blue-500' },
  listo:        { label: 'Listo',           clase: 'bg-green-50 text-green-700 border border-green-200',  punto: 'bg-green-500' },
  entregado:    { label: 'Entregado',       clase: 'bg-gray-50 text-gray-500 border border-gray-200',     punto: 'bg-gray-400' },
};

const ORDEN_ESTADOS = ['pendiente', 'preparacion', 'listo', 'entregado'];

function estadoLabel(estado) {
  return (ESTADOS[estado] || {}).label || estado;
}

function estadoClase(estado) {
  return (ESTADOS[estado] || {}).clase || 'bg-gray-100 text-gray-600';
}

function estadoPunto(estado) {
  return (ESTADOS[estado] || {}).punto || 'bg-gray-300';
}

function pasoEstado(key, estadoActual) {
  const idxPaso = ORDEN_ESTADOS.indexOf(key);
  const idxActual = ORDEN_ESTADOS.indexOf(estadoActual);
  if (idxPaso < idxActual) return 'bg-green-500';
  if (idxPaso === idxActual) return 'bg-[#C5A059] shadow-md';
  return 'bg-gray-200';
}

function pasoCompletado(key, estadoActual) {
  return ORDEN_ESTADOS.indexOf(key) < ORDEN_ESTADOS.indexOf(estadoActual);
}

function pasoActivo(key, estadoActual) {
  return key === estadoActual;
}

function pasoTextoClase(key, estadoActual) {
  const idxPaso = ORDEN_ESTADOS.indexOf(key);
  const idxActual = ORDEN_ESTADOS.indexOf(estadoActual);
  return idxPaso <= idxActual ? 'text-[#2A1B14] font-semibold' : 'text-[#2A1B14]/40';
}

function pasoLineaClase(key, estadoActual) {
  const idxPaso = ORDEN_ESTADOS.indexOf(key);
  const idxActual = ORDEN_ESTADOS.indexOf(estadoActual);
  if (idxPaso < idxActual) return 'bg-green-500';
  if (idxPaso === idxActual) return 'bg-[#C5A059]';
  return 'bg-gray-200';
}
