Dacorp Extra Bundle
====================

Collection of services, helper, and standard view for standard services you want to use in any kind of website.

It's a **Work in Progress** mainly used for other project. You can browse the repository, but I would not recommend you to use it unless you know what you want ;)

This branch (master) supports PUGXMultuUserBundle master, FOSUserBundle master and Symfony master.

The branch (1.0) supports PUGXMultuUserBundle 2.0, FOSUserBundle 2.0 and Symfony >=2.1, <2.4.


Some of the feature included :

* Image Uploader Service : Integration of Punkave Image Uploader as a service tight to a generic Media Model (plan to update to https://github.com/1up-lab/OneupUploaderBundle)
* Simple README functionality included by default on demand (usually dev environment only is fine) : give you a page with a html rendered version of the README.md Markdown file located in the root of your Project
* Manage metas for twitter cards and open graph
* Provide switch lang feature (routes, knpmenu action, and Handler)


##Using the ImageUploader Service:

include the default uploader
    {% include "DacorpExtraBundle:Common:file-upload-control.html.twig" %}

## Twig extension to manage metas

Support Twitter Card and Facebook Open graph Meta in a simple way with Twig extension.

### Add global twig variables for specific data

####Define specific account data in parameters.yml.dist
    parameters:
        facebook_app_id: XXX
        twitter_widget_id: XXX
        twitter_default_account: XXX

####Update globals
    twig:
        globals:
            facebook_app_id: %facebook_app_id%
            twitter_default_account: %twitter_default_account%

####Call twig extension within twig template

partner is an entity which has all needed informations to generate basic open graph meta and basic twitter card (only restaurant.restaurant supported for now).

    {% block head_meta %}
        {{ allMetas({'title': partner.title, 'description':partner.description,
        'url': path('get_partner', { 'alias': partner.alias }) , 'object':partner, 'images': partner.partnerMedias}) }}
    {% endblock %}

##Using the switch lang feature
### Add the route

##Using some extended mopa forms

We extends the mopa form widget with some updated widgets.
Have a look to `Resources/views/Form/fields.html.twig`

And setup mopa to use that form field definition file

```yaml

mopa_bootstrap:
    form:
        templating:           DacorpExtraBundle:Form:fields.html.twig
```
