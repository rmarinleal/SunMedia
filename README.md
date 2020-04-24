##Prueba backend SunMedia

Para la prueba de código de backend vamos a necesitar que implementes una serie de interfaces definidas en este repositorio. El objetivo de esta prueba es ver como te enfrentas a un problema de modelado de clases con una dificultad moderada en un tiempo de desarrollo bastante ajustado.

Junto con la definición de las interfaces también van acompañados una batería de tests que aseguran el cumplimiento los requisitos del problema que a continuación se detallan. Para la evaluación del problema será necesario que los tests estén pasando correctamente. Podrás añadir todos los tests que creas necesario pero no puedes modificar ni borrar los actuales.

### Requisitos del caso de uso

En nuestra empresa estamos desarrollando un exchange. Un **exchange** es el encargado de decidir qué **campaña** se le va a servir a qué **usuario**. Para ello hemos definido una interfaz **ExchangeInterface**.

#### ExchangeInterface

```php
<?php

namespace SunMedia;

interface ExchangeInterface
{
    public function match(UserInterface $user): ?CampaignInterface;

    public function addCampaign(CampaignInterface $campaign): void;

    public function removeCampaign(CampaignInterface $campaign): void;

    public function campaigns(): array;

    public function getCampaignById(int $id): ?CampaignInterface;
}
```

Esta clase será la encargada de saber qué campañas están activas y qué campañas concuerdan con el usuario al que se le está intentando asignar una campaña. Las campañas tienen asignada una prioridad que puede ser **high** o **low**. 
Las campañas que estén marcadas como **high** tendrán prioridad para ser servidas sobre las campañas marcadas como **low**.

Aparte del **exchange** también necesitamos que desarrolles dos clases mas que nos ayuden en el flujo de decisión de qué **campaña** corresponde a qué **usuario**: 


#### UserInterface

Esta clase representa la información del usuario para el cual tenemos que devolver una campaña que concuerde con sus características.

```php
<?php

namespace SunMedia;

interface UserInterface
{
    public function gender(): string;

    public function device(): string;

    public function age(): int;
}
```

#### CampaignInterface

Esta clase representa la información de la campaña que contiene la información hacia la audiencia que va dirigida la campaña.

```php
<?php

namespace SunMedia;

interface CampaignInterface
{
    public function id(): int;

    public function gender(): string;

    public function priority(): string;

    public function device(): string;

    public function ageSegment(): string;

    public function status(): string;

    public function stop(): void;

    public function start(): void;
}
```

El tiempo de desarrollo de esta prueba es de un máximo de 2 horas. Deberás enviar tu solución dentro de este marco temporal independientemente de si lo has completado o no para que podamos evaluarlo. 

Algunas consideraciones:
- Para el desarrollo de esta prueba no necesitamos ningún tipo de persistencia.
- No necesitamos que desarrolles ningún endpoint o api.
- No se puede usar ningún framework.
