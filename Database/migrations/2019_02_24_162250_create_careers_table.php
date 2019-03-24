<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('careers', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->integer('school_id')->unsigned();
          $table->foreign('school_id', 'fk_career_school')->references('id')->on('schools');
          $table->softDeletes();
          $table->timestamps();
        });

      DB::insert("INSERT INTO careers (`id`,`name`,`school_id`,`deleted_at`,`created_at`,`updated_at`) VALUES (1,'Licenciatura en Biologia',3,NULL,NULL,NULL),
      (2,'Licenciatura en Computacion',4,NULL,NULL,NULL),
      (3,'Licenciatura en Fisica',5,NULL,NULL,NULL),
      (4,'Licenciatura en Matematica',6,NULL,NULL,NULL),
      (5,'Licenciatura en Quimica',7,NULL,NULL,NULL),
      (6,'Licenciatura en Geoquimica',8,NULL,NULL,NULL),
      (7,'Antropologia',10,NULL,'2019-03-04 03:14:53','2019-03-04 03:14:53'),
      (8,'Derecho',35,NULL,'2019-03-04 03:15:17','2019-03-04 03:15:17'),
      (9,'Arquitectura',2,NULL,'2019-03-04 03:15:40','2019-03-04 03:15:40'),
      (10,'Licenciado en Administración Comercial',9,NULL,'2019-03-04 03:16:29','2019-03-04 03:16:29'),
      (11,'Licenciado en Archivología',18,NULL,'2019-03-04 03:16:41','2019-03-04 03:16:41'),
      (12,'Licenciado en Artes',17,NULL,'2019-03-04 03:16:51','2019-03-04 03:16:51'),
      (13,'Licenciado en Bibliotecología',18,NULL,'2019-03-04 03:16:59','2019-03-04 03:16:59'),
      (14,'Licenciado en Bioanálisis',37,NULL,'2019-03-04 03:17:15','2019-03-04 03:17:15'),
      (15,'Licenciado en Ciencias Actuariales',11,NULL,'2019-03-04 03:17:31','2019-03-04 03:17:31'),
      (16,'Licenciado en Ciencias Estadísticas',11,NULL,'2019-03-04 03:17:41','2019-03-04 03:17:41'),
      (17,'Licenciado en Ciencias Políticas y Administrativas',36,NULL,'2019-03-04 03:18:10','2019-03-04 03:18:10'),
      (18,'Licenciado en Comunicación Social',19,NULL,'2019-03-04 03:18:21','2019-03-04 03:18:21'),
      (19,'Licenciado en Contaduría Pública',9,NULL,'2019-03-04 03:18:29','2019-03-04 03:18:29'),
      (20,'Técnico Superior en Cardiopulmonar',42,NULL,'2019-03-04 03:18:56','2019-03-04 03:18:56'),
      (21,'Técnico Superior en Citotecnología',42,NULL,'2019-03-04 03:19:12','2019-03-04 03:19:12'),
      (22,'Economia',12,NULL,'2019-03-04 03:19:30','2019-03-04 03:19:30'),
      (23,'Licenciado en Educación',20,NULL,'2019-03-04 03:19:44','2019-03-04 03:19:44'),
      (24,'Licenciado en Educación Mención Historia',20,NULL,'2019-03-04 03:19:54','2019-03-04 03:19:54'),
      (25,'Licenciado en Educación Mención Artes',20,NULL,'2019-03-04 03:20:08','2019-03-04 03:20:08'),
      (26,'Licenciado en Educación Mención Biologia',20,NULL,'2019-03-04 03:20:19','2019-03-04 03:20:19'),
      (27,'Licenciado en Educación Mención Ciencias Sociales',20,NULL,'2019-03-04 03:20:31','2019-03-04 03:20:31'),
      (28,'Licenciado en Educacion Mención Filosofía',20,NULL,'2019-03-04 03:20:40','2019-03-04 03:20:40'),
      (29,'Licenciado en Educación Mención Matemática',20,NULL,'2019-03-04 03:20:48','2019-03-04 03:20:48'),
      (30,'Licenciado en Educación Mención Química',20,NULL,'2019-03-04 03:21:02','2019-03-04 03:21:02'),
      (31,'Licenciado en Enfermería',38,NULL,'2019-03-04 03:21:35','2019-03-04 03:21:35'),
      (32,'Técnico Superior en Enfermería',38,NULL,'2019-03-04 03:21:43','2019-03-04 03:21:43'),
      (33,'Licenciado en Estudios Internacionales',13,NULL,'2019-03-04 03:22:06','2019-03-04 03:22:06'),
      (34,'Farmacia',16,NULL,'2019-03-04 03:22:16','2019-03-04 03:22:16'),
      (35,'Licenciado en Filosofía',21,NULL,'2019-03-04 03:22:27','2019-03-04 03:22:27'),
      (36,'Licenciado en Fisioterapia',42,NULL,'2019-03-04 03:22:46','2019-03-04 03:22:46'),
      (37,'Licenciado en Geografía',22,NULL,'2019-03-04 03:23:07','2019-03-04 03:23:07'),
      (38,'Licenciado en Historia',23,NULL,'2019-03-04 03:23:30','2019-03-04 03:23:30'),
      (39,'Licenciado en Idiomas Modernos',24,NULL,'2019-03-04 03:23:41','2019-03-04 03:23:41'),
      (40,'Ingeniero Agrónomo',1,NULL,'2019-03-04 03:23:49','2019-03-04 03:23:49'),
      (41,'Ingeniero Civil',28,NULL,'2019-03-04 03:23:57','2019-03-04 03:23:57'),
      (42,'Ingeniero de Minas',30,NULL,'2019-03-04 03:24:11','2019-03-04 03:24:11'),
      (43,'Ingeniero de Petróleo',34,NULL,'2019-03-04 03:24:19','2019-03-04 03:24:19'),
      (44,'Ingeniero de Procesos Industriales',31,NULL,'2019-03-04 03:24:39','2019-03-04 03:24:39'),
      (45,'Ingeniero Electricista',29,NULL,'2019-03-04 03:24:47','2019-03-04 03:24:47'),
      (46,'Ingeniero Geodesta',28,NULL,'2019-03-04 03:25:26','2019-03-04 03:25:26'),
      (47,'Ingeniero Geofísico',30,NULL,'2019-03-04 03:25:39','2019-03-04 03:25:39'),
      (48,'Ingeniero Geólogo',30,NULL,'2019-03-04 03:27:46','2019-03-04 03:27:46'),
      (49,'Ingeniero Hidrometeorologista',28,NULL,'2019-03-04 03:28:02','2019-03-04 03:28:02'),
      (50,'Ingeniero Mecánico',31,NULL,'2019-03-04 03:28:10','2019-03-04 03:28:10'),
      (51,'Ingeniero Metalúrgico',32,NULL,'2019-03-04 03:28:20','2019-03-04 03:28:20'),
      (52,'Ingeniero Químico',33,NULL,'2019-03-04 03:28:30','2019-03-04 03:28:30'),
      (53,'Técnico Superior en Información de Salud',42,NULL,'2019-03-04 03:28:44','2019-03-04 03:28:44'),
      (54,'Licenciatura en Inspección en Salud Pública',42,NULL,'2019-03-04 03:28:58','2019-03-04 03:28:58'),
      (55,'Licenciado en Letras',25,NULL,'2019-03-04 03:29:06','2019-03-04 03:29:06'),
      (56,'Médico Cirujano. Escuela Luís Razetti',40,NULL,'2019-03-04 03:29:18','2019-03-04 03:29:18'),
      (57,'Médico Cirujano. Escuela José María Vargas',39,NULL,'2019-03-04 03:29:27','2019-03-04 03:29:27'),
      (58,'Médico Veterinario',44,NULL,'2019-03-04 03:29:39','2019-03-04 03:29:39'),
      (59,'Licenciado en Nutrición y Dietética',41,NULL,'2019-03-04 03:29:51','2019-03-04 03:29:51'),
      (60,'Odontologia',43,NULL,'2019-03-04 03:30:03','2019-03-04 03:30:03'),
      (61,'Licenciado en Psicología',26,NULL,'2019-03-04 03:30:11','2019-03-04 03:30:11'),
      (62,'Técnico Superior en Radiología e Imagenología',42,NULL,'2019-03-04 03:30:35','2019-03-04 03:30:35'),
      (63,'Sociología',14,NULL,'2019-03-04 03:30:55','2019-03-04 03:30:55'),
      (64,'Licenciado en Terapia Ocupacional',42,NULL,'2019-03-04 03:31:09','2019-03-04 03:31:09'),
      (65,'Licenciado en Trabajo Social',15,NULL,'2019-03-04 03:31:20','2019-03-04 03:31:20'),
      (66,'Licenciado en Traducción',24,NULL,'2019-03-04 03:31:33','2019-03-04 03:31:33'),
      (67,'Licenciado en Traducción e Interpretación',24,NULL,'2019-03-04 03:31:54','2019-03-04 03:31:54')
      ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('careers');
    }
}
