import { useEffect, useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { useAuth0 } from '@auth0/auth0-react';
import { setLogged, login } from 'application/store/auth/actions';
import { getLocalStorageItem } from 'common/utils/localStorage';
import { getLogged } from 'application/store/auth/reducer';
import { isEndToEnd } from 'application/config/env';
import { endToEndIdTokenName } from 'application/config/variables';
import { ejectResponseInterceptor, setRefreshTokenInterceptor, setUserAccessToken } from 'common/http';
import { isBoolean, isNumber } from 'common/utils/type-predicates';

export const useAuth = () => {
  const dispatch = useDispatch();
  const logged = useSelector(getLogged);
  const { getIdTokenClaims, getAccessTokenSilently, isLoading, logout } = useAuth0();
  const [loading, setLoading] = useState(true);
  const [interceptor, setInterceptor] = useState(null);
  const ready = isBoolean(logged) && !isLoading && !loading;

  const startLogin = token => dispatch(login(token))
    .catch(() => dispatch(setLogged(false)))
    .finally(() => setLoading(false));

  useEffect(() => {
    if (isEndToEnd) {
      const idToken = getLocalStorageItem(endToEndIdTokenName);
      if (idToken) startLogin(idToken);
    } else {
      getIdTokenClaims().then(({ __raw: idToken }) => startLogin(idToken));
    }
  }, []);

  const logoutUser = () => logout({ returnTo: window.location.origin });

  const updateToken = () => getAccessTokenSilently()
    .then((idToken) => {
      setUserAccessToken(idToken);
      return idToken;
    });

  useEffect(() => {
    if (isNumber(interceptor)) {
      ejectResponseInterceptor(interceptor);
      setInterceptor(null);
    }
    if (logged) {
      setInterceptor(setRefreshTokenInterceptor(updateToken, logoutUser));
    }
  }, [logged]);

  return ready;
};