-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Users`
--

CREATE TABLE Users (
    id_usuario INT PRIMARY KEY IDENTITY(1,1),
    Nombre VARCHAR(50),
    Ape_Pat VARCHAR(50),
    Ape_Mat VARCHAR(50),
    Correo VARCHAR(100),
    Usuario VARCHAR(50),
    Password VARCHAR(150),
    id_rol INT,
    Fecha_ingreso DATE,
    FechOpe DATE,
    HoraOpe TIME,
    Estatus BIT
);

--
-- Volcado de datos para la tabla `Users`
--

INSERT INTO Users (Nombre, Ape_Pat, Ape_Mat, Correo, Usuario, Password, Fecha_ingreso, FechOpe, HoraOpe, Estatus)
VALUES
('Arturo', 'Téllez', 'Durán', 'a.tellez@nexen-elog.com', 'ARTEDU', 'ARTEDU2023', '2023-10-27', '2023-10-27', CONVERT(TIME, '17:11:00'), 1),
('Brenda', 'Moreno', '', 'brenda.moreno@xtrategas.com', 'BRMORENO', 'BR2024', '2023-10-03', '2024-01-17', CONVERT(TIME, '09:00:00'), 1),
('IVAN', 'MEDINA', 'VALDEZ', 'aux.facturacion@aa-nexen.com', 'IMVZAX', 'IMVZAX241255', '2024-03-21', '2024-03-21', CONVERT(TIME, '13:27:00'), 1),
('CARLOS', 'SARABIA', 'SARABIA', 'carlosc@xtrategas.com', 'CAR2023', 'NCAR2023', '2023-12-04', '2023-10-03', CONVERT(TIME, '10:11:00'), 1),
('Cesar', 'Fregoso', 'Acuña', 'cesar.fregoso@xtraentrega.com', 'CFREGOSO', 'CF2024', '2024-01-17', '2024-01-17', CONVERT(TIME, '9:00:00'), 1),
('Christian Alejandro', 'Fregoso', 'Duran', 'christian.fregoso@xtrategas.com', 'CHRD', 'CHRD2024', '2024-02-16', '2024-02-16', CONVERT(TIME, '11:25:00'), 1),
('ROSA MARIA', 'LEAN', 'RIVERA', 'contacto2@nexen-elog.com', 'RMLR', 'RMLR2024', '2024-04-30', '2024-04-30', CONVERT(TIME, '17:11:00'), 1),
('JARI', 'OVIEDO', 'RAMIREZ', 'desarrollo.1@nexen-elog.com', 'JARI', 'JARI2023', '2023-10-03', '2023-10-03', CONVERT(TIME, '10:11:00'), 1),
('PORFI', 'GARCIA', 'LLAMAS', 'desarrollo.3@nexen-elog.com', 'PORFI', 'PORFI2023', '2023-10-03', '2023-10-03', CONVERT(TIME, '10:11:00'), 1),
('JUAN', 'AMEZCUA', 'ESPINOBARROS', 'desarrollo.4@nexen-elog.com', 'JUAN', 'JUAN2023', '2023-10-03', '2023-10-03', CONVERT(TIME, '10:11:00'), 1),
('OMAR', 'FIGUEROA', 'HERNANDEZ', 'desarrollo.5@nexen-elog.com', 'OMAR', 'OMAR2023', '2023-10-03', '2023-10-03', CONVERT(TIME, '10:11:00'), 1),
('DIEGO ISRAEL', 'HAN', 'ENRIQUEZ', 'gerencia.desarrollo@nexen-elog.com', 'ADMIN', 'ADM2023', '2023-10-03', '2023-10-03', CONVERT(TIME, '14:02:00'), 1),
('EDUARDO', 'FLORES', 'LARA', 'leduardo@xtrategas.com', 'EDUF', 'NEXEN2023', '2023-10-16', '2023-10-16', CONVERT(TIME, '16:07:00'), 1),
('LUIS EDUARDO', 'FLORES', 'LARA', 'leduardo@xtrategas.com', 'LUEDF', 'password', '2023-10-03', '', '', 1),
('LUIS FERNANDO', 'VEGA', 'REYES', 'lf.vega@nexen-eleg.com', 'LUFVR', 'LUFVR2023', '2024-01-31', '2024-01-31', CONVERT(TIME, '12:00:00'), 1),
('LILIANA', 'RODRIGUEZ', 'BARROS', 'liliana.rodriguez@xtrategas.com', 'LBR', 'LNEXEN2023', '2023-10-03', '2023-12-04', CONVERT(TIME, '12:00:00'), 1),
('Rodolfo', 'San Juan', 'San Juan', 'r.sanjuan@nexen-elog.com', 'RODES', 'NEXEN2023', '2023-10-17', '2023-10-17', CONVERT(TIME, '11:11:00'), 1),
('VICTOR ANTONIO', 'MENDEZ', 'MARTINEZ', 'v.mendez@nexen-elog.com', 'VIAMM', 'NEXEN2023', '2023-10-03', '2023-10-16', CONVERT(TIME, '16:00:00'), 1)

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Roles`
--

CREATE TABLE Roles (
    id_rol INT PRIMARY KEY IDENTITY(1,1),
    nombre VARCHAR(50),
    estatus BIT
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Modulos`
--

CREATE TABLE Modulos (
    id_modulo INT PRIMARY KEY IDENTITY(1,1),
    nombre VARCHAR(50),
    estatus BIT
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Permisos`
--

CREATE TABLE Permisos (
    id_permiso INT PRIMARY KEY IDENTITY(1,1),
    id_rol INT,
    id_modulo INT,
    r BIT,
    w BIT,
    u BIT,
    d BIT,
    estatus BIT
);