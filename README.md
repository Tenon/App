App.init

App.server init

App.run => App.server.run

Monitor Process => Swoole Process

WorkerStart => set App and App refresh

Q: 需要在worker中尝试重新获取一个新的app对象吗？(eos是在重新在Worker类中初始化组件的)

A:目前考虑是在worker中重新获取App
Worker::setApplication() => $this->app = App::refreshApp();