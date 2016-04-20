#Application flow

On request happening, first thing we do is create application object. You can consider application as a simple command bus. There are three stages of application flow - boot, run, terminate. Each of the steps is a command to handle, application affectors can be added to do this.

Application affector is a simple command handler. As an argument, application instance is passed to handle function. At each step of application, each affector will be called to appropriate method in order to modify application.

Now, steps. Boot step is used to do several things - register all container bindings, load data for usage in application. This step will be most hard one, so performance optimisations should be always in the mind. Most likely, this step will be divided into two small steps. Mostly, because of container - after first registration of bindings, second run of bindings registration should be run in order to register container bindings, dependant on other bindings.

Run step will basically perform route resolve, call to middlewares and stuff, call to controller action. At the end of this run method application should return either Response object fot HTTP, ether Console Output Interface for cli commands.

Terminate step will be called last. This point is a great place for some actions, which should happen affter response is sent to browser. For example, some kind of FPC.

There are tow methods on application available out of application scope - setExtensionsHandler for application extending and setContainer in order for container implementation can be swapped.

Application itself should not do anything else, except running three steps of the flow. Everything else should be handled by application affectors.

#Request flow

Basically, nothing more to say on top of the PSR. How it should be done - router resolves route, calls middlewares, calls handler function (Contraller, Closure or whatever) and returns Response object to send out to browser.

