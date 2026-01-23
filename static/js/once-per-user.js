/* once-per-user.js  —— 任意动作只执行一次 */
function runOncePerUser(action, {
  key      = 'once_per_user_popup', // Cookie 名
  days     = 30,                   // 有效天数
  secure   = location.protocol === 'https:',
  domain   = '',                   // 默认同一域；如需 .vrocklab.hku.hk 再填
} = {}){

  /* 读 Cookie */
  const get = name =>
    document.cookie.split('; ')
      .find(c => c.startsWith(name + '='))?.split('=')[1];

  /* 写 Cookie */
  const set = (name, val, d) => {
    const t = new Date(); t.setTime(t.getTime() + d*864e5);
    document.cookie = [
      `${name}=${val}`,
      `expires=${t.toUTCString()}`,
      'path=/',
      'SameSite=Lax',
      secure ? 'Secure' : '',
      domain ? `domain=${domain}` : '',
    ].filter(Boolean).join('; ');
  };

  if (get(key)) return;     // 已执行 → 直接返回

  Promise.resolve()         // 允许 action return Promise
    .then(action)
    .finally(() => set(key, '1', days));
}
